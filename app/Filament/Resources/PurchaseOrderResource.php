<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PurchaseOrderResource\Pages;
use App\Filament\Resources\PurchaseOrderResource\RelationManagers;
use App\Models\PurchaseOrder;
use App\Models\PurchaseRequest;
use App\Models\Vendors;
use App\Models\PurchaseRequestItem;
use DateTime;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Resources\Resource;
use Filament\Support\Enums\Alignment;
use Filament\Tables;
use Filament\Tables\Actions\Action;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Livewire\Attributes\Reactive;

class PurchaseOrderResource extends Resource
{
    protected static ?string $model = PurchaseOrder::class;

    protected static ?string $navigationIcon = 'heroicon-o-shopping-bag';

    protected static ?string $navigationLabel = 'Purchase Order';

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }

    protected static ?string $navigationGroup = 'Purchasing';

    public static function form(Form $form): Form
    {
        $number = 0;
        $number = PurchaseOrder::latest()->value('Number');
        return $form
            ->schema([
                TextInput::make('PO_Code')->label('Purchase Order Code')->default('#PO-0000' . $number++ . date('-Y'))->readOnly(true),
                Hidden::make('Number')->default($number++),
                TextInput::make('PO_Name')->label('Purchase Order Name')->required(),
                Select::make('Vendors')->required()
                    ->relationship(name: 'vendors', titleAttribute: 'CompanyName')
                    ->options(Vendors::pluck('CompanyName', 'id'))
                    ->reactive()
                    ->searchable()
                    ->afterStateUpdated(function ($state, Set $set) {
                        // Fetch the selected vendor
                        $vendor = Vendors::find($state);
                        $number = 0;
                        $number = PurchaseOrder::latest()->value('Number');
                        if ($vendor) {
                            // Generate the PO_Code with the vendor's name
                            $poCode = '#PO-0000' . $number++ . date('-Y') . '-' . strtoupper(substr($vendor->VendorCode, 0, 3));
                            $set('PO_Code', $poCode);
                        }
                    }),
                Select::make('Purchase_Request')->required()->label('Purchase Request')->live()->reactive()
                    ->options(PurchaseRequest::pluck('PR_Code', 'id'))
                    ->searchable()
                    ->reactive()
                    ->afterStateUpdated(function ($state, Set $set) {
                        $purchaseRequest = PurchaseRequest::with('items')->find($state);
                        if ($purchaseRequest) {
                            $items = $purchaseRequest->items->map(function ($item) {
                                return [
                                    'Item_Name' => $item->Item_Name,
                                    'Item_Description' => $item->Item_Description,
                                    'Quantity' => $item->Quantity,
                                    'Price' => $item->Price,
                                    'Unit' => $item->Unit,
                                    'Tax' => $item->Tax,
                                    'Total' => $item->Total,
                                ];
                            })->toArray();

                            $set('purchaseOrderItems', $items);
                        } else {
                            $set('purchaseOrderItems', []);
                        }
                    })
                    ->required(),
                // ->relationship(name: 'purchaseRequest', titleAttribute: 'PR_Code'),
                DateTimePicker::make('Order_Date')->label('Order Date')->required(),
                Select::make('Department')->required()
                    ->relationship(name: 'purchaseRequest', titleAttribute: 'Department'),
                Select::make('Category')->required()
                    ->relationship(name: 'purchaseRequest', titleAttribute: 'Category'),
                Select::make('Project')->required()
                    ->relationship(name: 'purchaseRequest', titleAttribute: 'Project'),

                /* Items Detail */
                Repeater::make('purchaseOrderItems')
                    ->label('Items Detail')
                    ->relationship()
                    ->schema([
                        TextInput::make('Item_Name')->required(),
                        TextInput::make('Item_Description')->required(),
                        TextInput::make('Quantity')
                            ->numeric()
                            ->required()
                            ->reactive()
                            ->afterStateUpdated(function (Set $set, $state, Get $get) {
                                $set('Total', $state * $get('Price'));
                            }),
                        TextInput::make('Price')
                            ->numeric()
                            ->prefix('Rp.')
                            ->required()
                            ->reactive()
                            ->afterStateUpdated(function (Set $set, $state, Get $get) {
                                $set('Total', $state * $get('Quantity'));
                            }),
                        TextInput::make('Unit')->numeric()->required(),
                        TextInput::make('Tax'),
                        TextInput::make('Total')->numeric()->readOnly(),
                    ])
                    ->columns(7)
                    ->columnSpan(2)
                    ->addActionLabel('Tambah Item')
                    ->reorderable()
                    ->collapsible()
                    ->cloneable(),

                /* Result */
                Fieldset::make()
                    ->schema([
                        /* Total */
                        TextInput::make('SubTotal')
                            ->placeholder(function (Set $set, Get $get) {
                                $SubTotal = collect($get('purchaseOrderItems'))->pluck('Total')->sum();
                                if ($SubTotal == null) {
                                    $set('SubTotal', 0);
                                } else {
                                    $set('SubTotal', $SubTotal);
                                }
                            })->readOnly(true),
                        /* Grand Total */
                        TextInput::make('GrandTotal')->label('Grand Total')
                            ->placeholder(function (Set $set, Get $get) {
                                $Grandtotal = collect($get('purchaseOrderItems'))->pluck('Total')->sum();
                                if ($Grandtotal == null) {
                                    $set('GrandTotal', 0);
                                } else {
                                    $set('GrandTotal', $Grandtotal);
                                }
                            })->readOnly(true),
                    ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('PO_Code')->label('PR Code'),
                TextColumn::make('PO_Name')->label('PR Name'),
                TextColumn::make('Vendors')->label('Vendors Type'),
                TextColumn::make('Order_Date')->label('Order_Date'),
                TextColumn::make('Project')->label('Purchase Type'),
                TextColumn::make('GrandTotal'),
            ])
            ->emptyStateHeading('Belum ada Data Purchasing!')
            ->emptyStateDescription('Silahkan tambahkan Purchase Order')
            ->emptyStateIcon('heroicon-o-shopping-bag')
            ->emptyStateActions([
                Action::make('create')
                    ->label('Tambahkan Purchase Order')
                    ->url(route('filament.admin.resources.purchase-orders.create'))
                    ->icon('heroicon-m-plus')
                    ->button(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPurchaseOrders::route('/'),
            'create' => Pages\CreatePurchaseOrder::route('/create'),
            'edit' => Pages\EditPurchaseOrder::route('/{record}/edit'),
        ];
    }
}
