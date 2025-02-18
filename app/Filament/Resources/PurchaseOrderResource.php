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
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
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
use PhpParser\Node\Stmt\Label;

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
                Hidden::make('Purchase_Requests_ID')->nullable()->default(null),
                TextInput::make('PO_Code')
                    ->label('Purchase Order Code')
                    ->default(function () {
                        $lastNumber = \App\Models\PurchaseOrder::latest()->value('Number') ?? 0;
                        $nextNumber = str_pad($lastNumber + 1, 5, '0', STR_PAD_LEFT);
                        return "#PO-" . $nextNumber++ . '-' . date('Y');
                    })
                    ->readOnly(),
                Hidden::make('Number')->default($number++),
                TextInput::make('PO_Name')->label('Purchase Order Name')->required(),
                Select::make('Vendors')->required()
                    ->relationship(name: 'vendors', titleAttribute: 'CompanyName')
                    ->options(Vendors::pluck('CompanyName', 'id'))
                    ->reactive()
                    ->searchable()
                    ->afterStateUpdated(function ($state, Set $set) {
                        // Ambil vendor yang dipilih
                        $vendor = Vendors::find($state);

                        // Ambil nomor PO terakhir dan tingkatkan nilainya
                        $lastNumber = PurchaseOrder::latest()->value('Number') ?? 0;
                        $nextNumber = str_pad($lastNumber + 1, 4, '0', STR_PAD_LEFT); // Format jadi 0001, 0002, dst.

                        if ($vendor) {
                            // Gunakan VendorCode secara lengkap
                            $vendorCode = strtoupper($vendor->VendorCode);

                            // Format PO_Code: #PO-{nomor urut}{tahun}-{VENDORCODE}
                            $poCode = "#PO-{$nextNumber}" . date('-Y') . "-{$vendorCode}";

                            // Set PO_Code ke field
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
                DateTimePicker::make('Order_Date')->label('Order Date')->required()
                    ->native(false)
                    ->firstDayOfWeek(1)
                    ->closeOnDateSelection()
                    ->timezone('Asia/Jakarta')
                    ->displayFormat('D, d-M-Y H:i:s')
                    ->default(now()),
                // Select::make('Department')->required()
                //     ->relationship(name: 'purchaseRequest', titleAttribute: 'Department')->label('Department'),
                // Select::make('Category')->required()
                //     ->relationship(name: 'purchaseRequest', titleAttribute: 'Category')->label('Category'),
                // Select::make('Project')->required()
                //     ->relationship(name: 'purchaseRequest', titleAttribute: 'Project')->label('Project'),
                Select::make('Department')->required()->label('Department')
                    ->options([
                        'Administrative' => 'Administrative',
                        'Operation' => 'Operation',
                        'Business Development' => 'Business Development',
                        'Executive' => 'Executive',
                        'Manufacture' => 'Manufacture',
                    ]),
                Select::make('Category')->required()->label('Category')
                    ->options([
                        'Operasional Kantor' => 'Operasional Kantor',
                        'Outstanding' => 'Outstanding',
                        'Manufaktur' => 'Manufaktur',
                        'Project' => 'Project',
                    ]),
                Select::make('Project')->required()->label('Project')
                    ->options([
                        'Zona 4' => 'Zona 4',
                        'Zona 11' => 'Zona 11',
                    ]),

                /* Order Item Details */
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
                                $totalAwal = $state * $get('Price'); // Hitung total awal
                                $diskon = $get('Discount'); // Ambil nilai diskon
                                if ($diskon > 0) {
                                    $totalSetelahDiskon = $totalAwal - ($totalAwal * ($diskon / 100)); // Hitung total setelah diskon
                                    $set('Total', $totalSetelahDiskon);
                                } else {
                                    $set('Total', $totalAwal); // Kembalikan ke total awal jika diskon 0 atau kosong
                                }
                            }),
                        TextInput::make('Price')
                            ->numeric()
                            ->prefix('Rp.')
                            ->required()
                            ->reactive()
                            ->afterStateUpdated(function (Set $set, $state, Get $get) {
                                $totalAwal = $state * $get('Quantity'); // Hitung total awal
                                $diskon = $get('Discount'); // Ambil nilai diskon
                                if ($diskon > 0) {
                                    $totalSetelahDiskon = $totalAwal - ($totalAwal * ($diskon / 100)); // Hitung total setelah diskon
                                    $set('Total', $totalSetelahDiskon);
                                } else {
                                    $set('Total', $totalAwal); // Kembalikan ke total awal jika diskon 0 atau kosong
                                }
                            }),
                        TextInput::make('Unit')->required(),
                        Select::make('Tax')->label('Tax')
                            ->options([
                                'PPH' => 'PPH (2%)',
                                'PPN' => 'PPN (12%)',
                                'None' => 'Tanpa Pajak'
                            ])
                            ->reactive()
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

                        TextInput::make('Discount')
                            ->Label('Discount(%)')
                            ->numeric()
                            ->reactive()
                            ->afterStateUpdated(function (Set $set, $state, Get $get) {
                                $totalAwal = $get('Price') * $get('Quantity'); // Hitung total awal
                                if ($state > 0) {
                                    $totalSetelahDiskon = $totalAwal - ($totalAwal * ($state / 100)); // Hitung total setelah diskon
                                    $set('Total', $totalSetelahDiskon);
                                } else {
                                    $set('Total', $totalAwal); // Kembalikan ke total awal jika diskon 0 atau kosong
                                }
                            }),
                        TextInput::make('Total')->numeric()->readOnly(),
                    ])
                    ->columns(8)
                    ->columnSpan(2)
                    ->addActionLabel('Tambah Item')
                    ->reorderable()
                    ->collapsible()
                    ->cloneable(),

                /* Result */
                Fieldset::make()->columns(1)->columnSpan(1)->columnStart(2)->label('Result')
                    ->schema([
                        /* Total */
                        TextInput::make('Sub_Total')
                            ->placeholder(function (Set $set, Get $get) {
                                $SubTotal = collect($get('purchaseOrderItems'))->pluck('Total')->sum();
                                $set('Sub_Total', $SubTotal ?? 0);
                            })->readOnly(true)->debounce(1000),

                        /* Discount */
                        Grid::make()->schema([
                            TextInput::make('Discounts')
                                ->label('Discount')
                                ->numeric()
                                ->reactive()
                                ->afterStateUpdated(function (Set $set, Get $get) {
                                    $discount = (float) $get('Discounts');
                                    $subTotal = (float) $get('Sub_Total');
                                    $discountType = $get('Discount_Type');
                                    $shippingFee = (float) $get('Shipping_Fee');

                                    // Hitung Total Discount
                                    if ($discountType === 'Amount') {
                                        $totalDiscount = min($discount, $subTotal);
                                    } elseif ($discountType === 'Percent') {
                                        $totalDiscount = ($discount / 100) * $subTotal;
                                    } else {
                                        $totalDiscount = 0;
                                    }

                                    // Hitung Grand Total setelah diskon dan Shipping Fee
                                    $grandTotal = max(($subTotal - $totalDiscount) - $shippingFee, 0);

                                    $set('Total_Discount', $totalDiscount);
                                    $set('Grand_Total', $grandTotal);
                                })->debounce(1000),

                            Select::make('Discount_Type')
                                ->label('Jenis Diskon')
                                ->options([
                                    'Amount' => 'Amount',
                                    'Percent' => '%',
                                ])
                                ->reactive()
                                ->afterStateUpdated(function (Set $set, Get $get) {
                                    $discount = (float) $get('Discounts');
                                    $subTotal = (float) $get('Sub_Total');
                                    $discountType = $get('Discount_Type');
                                    $shippingFee = (float) $get('Shipping_Fee');

                                    // Hitung Total Discount
                                    if ($discountType === 'Amount') {
                                        $totalDiscount = min($discount, $subTotal);
                                    } elseif ($discountType === 'Percent') {
                                        $totalDiscount = ($discount / 100) * $subTotal;
                                    } else {
                                        $totalDiscount = 0;
                                    }

                                    // Hitung Grand Total setelah diskon dan Shipping Fee
                                    $grandTotal = max(($subTotal - $totalDiscount) - $shippingFee, 0);

                                    $set('Total_Discount', $totalDiscount);
                                    $set('Grand_Total', $grandTotal);
                                })->debounce(1000),

                            TextInput::make('Total_Discount')->label('Total Discount')->readOnly(true),

                            TextInput::make('Shipping_Fee')
                                ->label('Shipping Fee')
                                ->numeric()
                                ->reactive()
                                ->afterStateUpdated(function (Set $set, Get $get) {
                                    $subTotal = (float) $get('Sub_Total');
                                    $totalDiscount = (float) $get('Total_Discount');
                                    $shippingFee = (float) $get('Shipping_Fee');

                                    // Hitung Grand Total
                                    $grandTotal = max(($subTotal - $totalDiscount) + $shippingFee, 0);

                                    // Set Grand Total
                                    $set('Grand_Total', $grandTotal);

                                    // Konversi Grand Total ke terbilang
                                    $set('Terbilang', ucwords(terbilang($grandTotal)) . " Rupiah");
                                })->debounce(1000),
                        ]),

                        /* Grand Total */
                        TextInput::make('Grand_Total')
                            ->label('Grand Total')
                            ->reactive()
                            ->afterStateUpdated(function (Set $set, Get $get) {
                                $grandTotal = (float) $get('Grand_Total');
                                $set('Terbilang', ucwords(terbilang($grandTotal)) . " Rupiah");
                            }),
                    ]),

                Fieldset::make()->columns(1)
                    ->schema([
                        TextInput::make('Terbilang')->label('Terbilang')->readOnly(),
                        TextInput::make('Delivery_Time')->label('Delivery Time'),
                        Textarea::make('Payment_Terms')->label('Payment Terms'),
                        Textarea::make('Inspection_Notes')->label('Inspection Notes'),
                        Textarea::make('Vendor_Notes')->label('Vendor Notes'),
                    ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('PO_Code')->label('PR Code'),
                TextColumn::make('PO_Name')->label('PR Name'),
                TextColumn::make('Vendors')->label('Vendors'),
                TextColumn::make('Order_Date')->label('Order_Date'),
                TextColumn::make('Project')->label('Purchase Type'),
                TextColumn::make('Grand_Total'),
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
