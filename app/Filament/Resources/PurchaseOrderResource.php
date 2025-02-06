<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PurchaseOrderResource\Pages;
use App\Filament\Resources\PurchaseOrderResource\RelationManagers;
use App\Models\PurchaseOrder;
use Filament\Forms;
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
        $number = PurchaseOrder::latest()->value('Number');
        return $form
            ->schema([
                TextInput::make('PO_Code')->label('Purchase Order Code')->default('#PO-0000' . $number++ . date('-Y'))->readOnly(true),
                // TextInput::make('Number')->label('Number')->default($number++),
                Hidden::make('Number')->default($number++),
                TextInput::make('PO_Name')->label('Purchase Order Name')->required(),
                Select::make('Vendor')->required()
                    ->relationship(name: 'vendors', titleAttribute: 'Company_Name'),
                Select::make('Purchase_Request')->required(),
                TextInput::make('Order_Date')->label('Order Date')->required(),
                Select::make('Department')->required(),
                Select::make('Category')->required(),
                Select::make('Project')->required(),

                /* Items Detail */
                Repeater::make('')->label('Items Detail')
                    ->relationship()
                    ->schema([
                        TextInput::make('Item_Name')->required(),
                        TextInput::make('Item_Description')->required(),
                        TextInput::make('Quantity')->numeric()->required()->debounce(600)
                            ->reactive()->afterStateUpdated(function (Set $set, $state, Get $get) {
                                $vHarga = $get('Price');
                                $set('Total', $state * $vHarga);
                            }),
                        TextInput::make('Price')->numeric()->prefix('Rp.')->required()
                            ->reactive()->debounce(600)
                            ->afterStateUpdated(function (Set $set, $state, Get $get) {
                                $vHarga = $get('Quantity');
                                $set('Total', $state * $vHarga);
                            })->required(),
                        TextInput::make('Unit')->numeric()->required(),
                        TextInput::make('Tax'),
                        TextInput::make('Total')->numeric()->readOnly(true),
                    ])->columns(7)->columnSpan(2)->addActionLabel('Tambah Item')->label('Tambahkan Item')->addActionAlignment(Alignment::Start)->reorderable(true)->reorderableWithButtons()->cloneable(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                //
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
