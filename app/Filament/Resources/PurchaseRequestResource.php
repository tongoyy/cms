<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PurchaseRequestResource\Pages;
use App\Filament\Resources\PurchaseRequestResource\RelationManagers;
use App\Models\PurchaseRequest;
use AutoIncrementTextInput;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Filament\Tables\Actions\Action;
use Filament\Forms;
use Filament\Forms\Components\Actions;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput\Mask;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Pages\Actions\Modal\Actions\ButtonAction;
use Filament\Resources\Resource;
use Filament\Support\Enums\Alignment;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Cheesegrits\FilamentGoogleMaps\Fields\Map;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\HtmlString;
use Joaopaulolndev\FilamentPdfViewer\Forms\Components\PdfViewerField;
use NunoMaduro\Collision\Adapters\Phpunit\State;
use PhpParser\Node\Stmt\Label;
use PrintFilament\Print\Infolists\Components\PrintComponent;
use Spatie\Browsershot\Browsershot;
use Torgodly\Html2Media\Tables\Actions\Html2MediaAction;

class PurchaseRequestResource extends Resource
{
    protected static ?string $model = PurchaseRequest::class;

    protected static ?string $navigationIcon = 'heroicon-o-shopping-cart';

    protected static ?string $navigationLabel = 'Purchase Request';

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }

    protected static ?string $navigationGroup = 'Purchasing';

    public static function form(Form $form): Form
    {
        $number = 0;
        $number = PurchaseRequest::latest()->value('Number');
        return $form
            ->schema([
                // Map::make('location'),
                TextInput::make('PR_Code')
                    ->label('Purchase Request Code')
                    ->default(function (Get $get) {
                        $lastNumber = \App\Models\PurchaseRequest::latest()->value('Number') ?? 0;
                        $nextNumber = str_pad($lastNumber + 1, 5, '0', STR_PAD_LEFT);
                        $department = strtoupper(str_replace(' ', '', $get('Department') ?? '')); // Ambil Department tanpa spasi
                        return "#PR-" . $nextNumber . '-' . date('Y') . '-' . $department;
                    })
                    ->reactive()
                    ->readOnly(),

                // TextInput::make('Number')->label('Number')->default($number++),
                Hidden::make('Number')->default($number + 1),
                TextInput::make('PR_Name')->label('Purchase Request Name')->required(),
                Select::make('Project')->required()
                    ->options([
                        'Zona 4' => 'Zona 4',
                        'Zona 11' => 'Zona 11',
                    ]),
                Select::make('Department')
                    ->required()
                    ->options([
                        'Administrative' => 'Administrative',
                        'Operation' => 'Operation',
                        'Business Development' => 'Business Development',
                        'Executive' => 'Executive',
                        'Manufacture' => 'Manufacture',
                    ])
                    ->reactive()
                    ->live(debounce: 1000)
                    ->afterStateUpdated(function (Set $set, Get $get, $state) {
                        $lastNumber = \App\Models\PurchaseRequest::latest()->value('Number') ?? 0;
                        $nextNumber = str_pad($lastNumber + 1, 5, '0', STR_PAD_LEFT);
                        $department = strtoupper(str_replace(' ', '', $state)); // Ambil Department tanpa spasi
                        $prCode = "#PR-" . $nextNumber . '-' . date('Y') . '-' . $department;

                        // Set PR_Code dengan format baru
                        $set('PR_Code', $prCode);
                    }),
                Select::make('PurchaseType')->required()
                    ->options([
                        'Barang' => 'Barang',
                        'Jasa' => 'Jasa',
                        'Pembiayaan' => 'Pembiayaan',
                    ])->label('Purchase Type'),
                Select::make('Category')->required()
                    ->options([
                        'Operasional Kantor' => 'Operasional Kantor',
                        'Outstanding' => 'Outstanding',
                        'Manufaktur' => 'Manufaktur',
                        'Project' => 'Project',
                    ]),
                DateTimePicker::make('DueDate')->label('Due Date')->required()
                    ->native(false)
                    ->firstDayOfWeek(1)
                    ->closeOnDateSelection()
                    ->timezone('Asia/Jakarta')
                    ->locale('id')
                    ->displayFormat('D, d-M-Y H:i:s')
                    ->default(now()),
                Textarea::make('Description')->nullable(),

                /* Items Detail */
                Repeater::make('purchaseRequestItems')->label('Items Detail')
                    ->relationship()
                    ->schema([
                        TextInput::make('Item_Name')->required(),
                        TextInput::make('Item_Description')->nullable(),
                        TextInput::make('Quantity')->numeric()->required()->live(debounce: 1000)
                            ->reactive()->afterStateUpdated(function (Set $set, $state, Get $get) {
                                $vHarga = $get('Price');
                                $set('Total', $state * $vHarga);
                            }),
                        TextInput::make('Price')->numeric()->prefix('Rp.')->required()
                            ->reactive()->live(debounce: 1000)
                            ->afterStateUpdated(function (Set $set, $state, Get $get) {
                                $vHarga = $get('Quantity');
                                $numericPrice = (float) str_replace('.', '', $state); // Remove formatting for calculation
                                $set('Price', $numericPrice);
                                $set('Total', $numericPrice * $vHarga);
                            })->required()->currencyMask(thousandSeparator: ',', decimalSeparator: '.', precision: 2),

                        // TextInput::make('Price')->numeric()->prefix('Rp.')->required()
                        //     ->reactive()->live(debounce: 500)
                        //     ->afterStateUpdated(function (Set $set, $state, Get $get) {
                        //         $vHarga = $get('Quantity');
                        //         $set('Total', $state * $vHarga);
                        //     })->required(),

                        TextInput::make('Unit')->required(),

                        Select::make('Tax')->label('Tax')->default('')->nullable()
                            ->options([
                                'PPH (2%)' => 'PPH (2%)',
                                'PPN (12%)' => 'PPN (12%)',
                                '' => ''
                            ])
                            ->reactive()
                            ->live(debounce: 1000)
                            ->afterStateUpdated(function (Set $set, Get $get) {
                                $total = (float) $get('Total');
                                $taxType = $get('Tax');

                                if ($taxType === 'PPH') {
                                    $taxAmount = 0.02 * $total; // 2% dari Total
                                } elseif ($taxType === 'PPN') {
                                    $taxAmount = 0.12 * $total; // 12% dari Total
                                } else {
                                    $taxAmount = 0;
                                }

                                $set('Tax_Amount', $taxAmount);
                                $set('Total', $total + $taxAmount);
                            }),

                        Hidden::make('Tax_Amount'),

                        TextInput::make('Total')->numeric()->readOnly(true),
                    ])
                    ->columns(7)
                    ->columnSpan(2)
                    ->addActionLabel('Tambah Item')
                    ->label('Tambahkan Item')
                    ->addActionAlignment(Alignment::Start)
                    ->reorderable(true)
                    ->reorderableWithButtons()
                    ->cloneable(),

                Fieldset::make()
                    ->schema([
                        /* Total */
                        TextInput::make('SubTotal')
                            ->placeholder(function (Set $set, Get $get) {
                                $SubTotal = collect($get('purchaseRequestItems'))->pluck('Total')->sum();
                                if ($SubTotal == null) {
                                    $set('SubTotal', 0);
                                } else {
                                    $set('SubTotal', $SubTotal);
                                }
                            })->readOnly(true),
                        /* Grand Total */
                        TextInput::make('GrandTotal')->label('Grand Total')
                            ->placeholder(function (Set $set, Get $get) {
                                $Grandtotal = collect($get('purchaseRequestItems'))->pluck('Total')->sum();
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
                TextColumn::make('PR_Code')->label('PR Code')->visibleFrom('md'),
                TextColumn::make('PR_Name')->label('PR Name'),
                TextColumn::make('Project'),
                TextColumn::make('Department'),
                TextColumn::make('PurchaseType')->label('Purchase Type'),
                TextColumn::make('Category'),
                TextColumn::make('DueDate')->label('Due Date')->date('d-M-Y'),
                TextColumn::make('Description')->limit(35),
                TextColumn::make('GrandTotal')->formatStateUsing(fn($state) => 'Rp ' . number_format($state, 0, ',', '.')),
            ])->searchable()
            ->emptyStateHeading('Belum ada Data Purchasing!')
            ->emptyStateDescription('Silahkan tambahkan Purchase Request')
            ->emptyStateIcon('heroicon-o-shopping-cart')
            ->emptyStateActions([
                Action::make('create')
                    ->label('Tambahkan Purchase Request')
                    ->url(route('filament.admin.resources.purchase-requests.create'))
                    ->icon('heroicon-m-plus')
                    ->button(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
                Tables\Actions\Action::make('pdf')
                    ->icon('heroicon-o-document-arrow-down')
                    ->url(fn(PurchaseRequest $record) => route('pdfPR', $record))
                    ->openUrlInNewTab()
                    ->label('PDF')
                    ->color('success'),
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
            'index' => Pages\ListPurchaseRequests::route('/'),
            'create' => Pages\CreatePurchaseRequest::route('/create'),
            'edit' => Pages\EditPurchaseRequest::route('/{record}/edit'),
        ];
    }
}
