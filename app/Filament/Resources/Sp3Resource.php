<?php

namespace App\Filament\Resources;

use App\Filament\Resources\Sp3Resource\Pages;
use App\Filament\Resources\Sp3Resource\RelationManagers;
use App\Models\PurchaseOrder;
use App\Models\PurchaseRequest;
use App\Models\Sp3;
use App\Models\Vendors;
use DateTime;
use Filament\Tables\Actions\Action;
use Filament\Forms;
use Filament\Forms\Components\Actions;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class Sp3Resource extends Resource
{
    protected static ?string $model = Sp3::class;

    protected static ?string $navigationIcon = 'heroicon-o-currency-dollar';

    protected static ?string $navigationLabel = 'SP3';

    protected static ?string $navigationGroup = 'Purchasing';

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }

    public static function form(Form $form): Form
    {
        $number = Sp3::latest()->value('Number');

        function hitungTotal(Set $set, Get $get)
        {
            $amount = (float) $get('Amount');
            $includePPN = $get('PPN');
            $includePPH = $get('PPH');

            $total = $amount;

            if ($includePPN) {
                $total += ($amount * 0.12); // Tambah 12%
            }

            if ($includePPH) {
                $total += ($amount * 0.02); // Tambah 2%
            }

            $set('Jumlah', $total);
            $jumlah = (float) $get('Jumlah');
            $set('Terbilang', ucwords(terbilang($jumlah)) . " Rupiah");
        }

        return $form
            ->schema([
                Fieldset::make()
                    ->schema([
                        Fieldset::make()->label('First Row')
                            ->schema([
                                TextInput::make('SP3_Number')->label('SP3 Number')
                                    ->default(function () {
                                        $lastNumber = \App\Models\Sp3::latest()->value('Number') ?? 0;
                                        $nextNumber = str_pad($lastNumber + 1, 5, '0', STR_PAD_LEFT);
                                        return $nextNumber++ . '/AMI-SP3/' . date('m/Y');
                                    })
                                    ->readOnly(),
                                Hidden::make('Number')->default($number++),

                                /* Purchase Request */
                                Select::make('Purchase_Request')->label('Purchase Request')
                                    ->live()
                                    ->visible(fn(Get $get): bool => !$get('Purchase_Order'))
                                    ->options(PurchaseRequest::pluck('PR_Code', 'id'))
                                    ->reactive()
                                    ->afterStateUpdated(function (Set $set, Get $get) {
                                        $PO = PurchaseRequest::latest()->value('GrandTotal') ?? 0;
                                        if ($PO) {
                                            $set('Amount', $PO);
                                            $set('Jumlah', $PO);
                                            $jumlah = (float) $get('Amount');
                                            $set('Terbilang', ucwords(terbilang($jumlah)) . " Rupiah");
                                        }
                                    }),

                                /* Purchase Request */
                                Select::make('Purchase_Order')->label('Purchase Order')
                                    ->live()
                                    ->visible(fn(Get $get): bool => !$get('Purchase_Request'))
                                    ->options(PurchaseOrder::pluck('PO_Code', 'id'))
                                    ->reactive()
                                    ->afterStateUpdated(function (Set $set, Get $get) {
                                        $PO = PurchaseOrder::latest()->value('Grand_Total') ?? 0;
                                        if ($PO) {
                                            $set('Amount', $PO);
                                            $set('Jumlah', $PO);
                                            $jumlah = (float) $get('Amount');
                                            $set('Terbilang', ucwords(terbilang($jumlah)) . " Rupiah");
                                        }
                                    }),

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

                                            $noRekening = Vendors::latest()->value('NomorRekening') ?? 0;

                                            $rekeningBank = Vendors::latest()->value('RekeningBank') ?? 0;;

                                            $namaVendor = Vendors::latest()->value('CompanyName') ?? 0;;
                                            // Set PO Code, Rekening Bank, Nomor Rekening, Atas Nama ke field
                                            $set('PO_Code', $poCode);
                                            $set('Rekening_Bank', $rekeningBank);
                                            $set('Nomor_Rekening', $noRekening);
                                            $set('Atas_Nama', $namaVendor);
                                        }
                                    }),

                                DateTimePicker::make('Date_Created')->label('Date Created')->required()
                                    ->native(false)
                                    ->firstDayOfWeek(1)
                                    ->closeOnDateSelection()
                                    ->timezone('Asia/Jakarta')
                                    ->locale('id')
                                    ->displayFormat('D, d-M-Y H:i:s')
                                    ->default(now()),
                                TextInput::make('Nama_Supplier')->label('Nama Supplier'),
                                TextInput::make('No_Invoice')->label('Nomor Invoice'),
                                DateTimePicker::make('Tanggal_Invoice')->label('Tanggal Invoice')->required()
                                    ->native(false)
                                    ->firstDayOfWeek(1)
                                    ->closeOnDateSelection()
                                    ->timezone('Asia/Jakarta')
                                    ->locale('id')
                                    ->displayFormat('D, d-M-Y H:i:s')
                                    ->default(now()),
                                TextInput::make('No_Kwitansi')->label('Nomor Kwitansi'),
                                DateTimePicker::make('Tanggal_Kwitansi')->label('Tanggal Kwitansi')->required()
                                    ->native(false)
                                    ->firstDayOfWeek(1)
                                    ->closeOnDateSelection()
                                    ->timezone('Asia/Jakarta')
                                    ->locale('id')
                                    ->displayFormat('D, d-M-Y H:i:s')
                                    ->default(now()),
                                TextInput::make('No_DO')->label('No Delivery Order'),
                                TextInput::make('Tanggal_DO')->label('Tanggal DO'),

                            ])->columns(4)->columnSpan(2),
                        Fieldset::make()->label('Second Row')
                            ->schema([
                                TextInput::make('No_FP')->label('No Faktur Pajak'),
                                DateTimePicker::make('Tanggal_FP')->label('Tanggal FP')->required()
                                    ->native(false)
                                    ->firstDayOfWeek(1)
                                    ->closeOnDateSelection()
                                    ->timezone('Asia/Jakarta')
                                    ->locale('id')
                                    ->displayFormat('D, d-M-Y H:i:s')
                                    ->default(now()),
                                Select::make('Jenis_Pembayaran')->label('Jenis Pembayaran')
                                    ->options([
                                        'Full Payment' => 'Full Payment',
                                        'Down Payment' => 'Down Payment',
                                        'Balance Payment' => 'Balance Payment',
                                    ]),
                                TextInput::make('Untuk_Pembayaran')->label('Untuk Pembayaran'),
                                TextInput::make('Rekening_Bank')->label('Rekening Bank')->readOnly(true),
                                TextInput::make('Nomor_Rekening')->label('Nomor Rekening')->readOnly(true),
                                TextInput::make('Atas_Nama')->label('Atas Nama')->readOnly(true),
                                TextInput::make('Lokasi')->label('Lokasi'),
                                Select::make('Paid_Status')->label('Paid Status')
                                    ->options([
                                        'Paid' => 'Paid',
                                        'Unpaid' => 'Unpaid',
                                    ]),
                                TextInput::make('Amount')->label('Amount')->readOnly()
                                    ->numeric()
                                    ->reactive()
                                    ->afterStateUpdated(fn(Set $set, Get $get) => hitungTotal($set, $get)),

                                Grid::make()
                                    ->schema([
                                        Checkbox::make('PPN')
                                            ->label('Tambahkan PPN (12%)')
                                            ->reactive()
                                            ->afterStateUpdated(fn(Set $set, Get $get) => hitungTotal($set, $get)),

                                        Checkbox::make('PPH')
                                            ->label('Tambahkan PPH (2%)')
                                            ->reactive()
                                            ->afterStateUpdated(fn(Set $set, Get $get) => hitungTotal($set, $get)),
                                    ])->columns(1)->columnSpan(2),

                                TextInput::make('Discount')->label('Discount'),
                                TextInput::make('Jumlah')->label('Jumlah')
                                    ->reactive()
                                    ->afterStateUpdated(function (Set $set, Get $get) {
                                        $jumlah = (float) $get('Jumlah');
                                        $set('Terbilang', ucwords(terbilang($jumlah)) . " Rupiah");
                                    }),
                                TextInput::make('Terbilang')->label('Terbilang'),
                            ])->columns(4)->columnSpan(2)
                    ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                //
            ])
            ->emptyStateHeading('Belum ada Data Purchasing!')
            ->emptyStateDescription('Silahkan tambahkan SP3 baru.')
            ->emptyStateIcon('heroicon-o-currency-dollar')
            ->emptyStateActions([
                Action::make('create')
                    ->label('Tambahkan Purchase Request')
                    ->url(route('filament.admin.resources.sp3s.create'))
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
            'index' => Pages\ListSp3s::route('/'),
            'create' => Pages\CreateSp3::route('/create'),
            'edit' => Pages\EditSp3::route('/{record}/edit'),
        ];
    }
}
