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
use Filament\Tables\Columns\TextColumn;
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
            // Ambil nilai Amount, PPN, PPH, dan Discount
            $amount = (float) $get('Amount') ?? 0;
            $ppn = $get('PPN') ? $amount * 0.12 : 0;
            $pph = $get('PPH') ? $amount * 0.02 : 0;
            $discount = (float) $get('Discount') ?? 0;

            // Hitung total setelah PPN, PPH, dan Diskon
            $total = ($amount + $ppn - $pph) - $discount;

            // Set nilai ke field 'Jumlah'
            $set('Jumlah', $total);

            // Konversi ke terbilang
            $set('Terbilang', ucwords(terbilang($total)) . " Rupiah");
        }

        return $form
            ->schema([
                Fieldset::make()
                    ->schema([
                        Fieldset::make()->label('Baris Pertama')
                            ->schema([
                                TextInput::make('SP3_Number')->label('SP3 Number')
                                    ->default(function (Get $get) {
                                        // Ambil nomor PO terakhir
                                        $lastNumber = \App\Models\sp3::latest()->value('Number') ?? 0;
                                        $nextNumber = str_pad($lastNumber + 1, 5, '0', STR_PAD_LEFT);

                                        // Ambil ID Vendor dari select
                                        $vendorId = $get('Vendors');
                                        $vendorCode = \App\Models\Vendors::where('id', $vendorId)->value('VendorCode') ?? '000';

                                        // Format PO Code
                                        return "{$nextNumber}/AMI-SP3/" . date('m/Y') . "-{$vendorCode}";
                                    })
                                    ->readOnly(),

                                /* Number */
                                Hidden::make('Number')->label('Number')->default($number + 1),

                                /* Purchase Request */
                                Select::make('Purchase_Request')->label('Purchase Request')
                                    ->live()
                                    ->visible(fn(Get $get): bool => !$get('Purchase_Order'))
                                    ->options(PurchaseRequest::pluck('PR_Code', 'id'))
                                    ->reactive()
                                    ->afterStateUpdated(function (Set $set, Get $get, $state) {
                                        if ($state) { // Jika ada yang dipilih
                                            $PR = PurchaseRequest::find($state)?->GrandTotal ?? 0;
                                            $set('Amount', $PR);
                                            $set('Jumlah', $PR);
                                            $set('Terbilang', ucwords(terbilang($PR)) . " Rupiah");
                                        } else {
                                            // Jika tidak ada yang dipilih, kosongkan field
                                            $set('Amount', null);
                                            $set('Jumlah', null);
                                            $set('Terbilang', null);
                                        }
                                    }),

                                /* Purchase Order */
                                Select::make('Purchase_Order')->label('Purchase Order')
                                    ->live()
                                    ->visible(fn(Get $get): bool => !$get('Purchase_Request'))
                                    ->options(PurchaseOrder::pluck('PO_Code', 'id'))
                                    ->reactive()
                                    ->afterStateUpdated(function (Set $set, Get $get, $state) {
                                        if ($state) {
                                            // Jika ada yang dipilih
                                            $PO = PurchaseOrder::find($state)?->Grand_Total ?? 0;
                                            $set('Amount', $PO);
                                            $set('Jumlah', $PO);
                                            $set('Terbilang', ucwords(terbilang($PO)) . " Rupiah");
                                        } else {
                                            // Jika tidak ada yang dipilih, kosongkan field
                                            $set('Amount', null);
                                            $set('Jumlah', null);
                                            $set('Terbilang', null);
                                        }
                                    }),

                                Select::make('Vendors')->required()
                                    ->relationship(name: 'vendors', titleAttribute: 'CompanyName')
                                    ->options(Vendors::pluck('CompanyName', 'id'))
                                    ->reactive()
                                    ->searchable()
                                    ->afterStateUpdated(function ($state, Set $set) {
                                        // Ambil vendor berdasarkan ID yang dipilih
                                        $vendor = Vendors::find($state);

                                        // Ambil nomor PO terakhir dan tingkatkan nilainya
                                        $lastNumber = PurchaseOrder::latest()->value('Number') ?? 0;
                                        $nextNumber = str_pad($lastNumber + 1, 4, '0', STR_PAD_LEFT); // Format 0001, 0002, dst.

                                        if ($vendor) {
                                            $lastNumber = \App\Models\sp3::latest()->value('Number') ?? 0;
                                            $nextNumber = str_pad($lastNumber + 1, 5, '0', STR_PAD_LEFT);

                                            // Ambil kode vendor berdasarkan ID yang dipilih
                                            $vendorCode = \App\Models\Vendors::where('id', $state)->value('VendorCode') ?? '000';

                                            // Format PO Code
                                            $poCode = "{$nextNumber}/AMI-SP3/" . date('m/Y') . "-{$vendorCode}";

                                            // Ambil informasi vendor sesuai ID yang dipilih
                                            $noRekening = $vendor->NomorRekening ?? '-';
                                            $rekeningBank = $vendor->RekeningBank ?? '-';
                                            $namaVendor = $vendor->CompanyName ?? '-';

                                            // Set field dengan data vendor yang dipilih
                                            $set('SP3_Number', $poCode);
                                            $set('Rekening_Bank', $rekeningBank);
                                            $set('Nomor_Rekening', $noRekening);
                                            $set('Atas_Nama', $namaVendor);
                                        } else {
                                            // Jika vendor tidak ditemukan, set field kosong
                                            $set('SP3_Number', '');
                                            $set('Rekening_Bank', '');
                                            $set('Nomor_Rekening', '');
                                            $set('Atas_Nama', '');
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
                                DateTimePicker::make('Tanggal_DO')->label('Tanggal DO')->required()
                                    ->native(false)
                                    ->firstDayOfWeek(1)
                                    ->closeOnDateSelection()
                                    ->timezone('Asia/Jakarta')
                                    ->locale('id')
                                    ->displayFormat('D, d-M-Y H:i:s')
                                    ->default(now()),

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
                                TextInput::make('Untuk_Pembayaran'),
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

                                TextInput::make('Discount')
                                    ->label('Discount')
                                    ->numeric()
                                    ->reactive()
                                    ->afterStateUpdated(fn(Set $set, Get $get) => hitungTotal($set, $get)),

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
                TextColumn::make('SP3_Number')->label('SP3 Number'),
                TextColumn::make('Nama_Supplier')->label('Nama_Supplier'),
                // TextColumn::make('purchaseRequestPR_Code')->label('PR Code'),
                // TextColumn::make('purchaseRequest.PO_Code')->label('PO Code'),
                TextColumn::make('purchaseRequest.PR_Code')
                    ->label('PR Number')
                    ->sortable()
                    ->searchable()
                    ->formatStateUsing(fn($record) => $record->purchaseRequest?->PR_Code ?? '-'),

                TextColumn::make('purchaseOrder.PO_Code')
                    ->label('PO Number')
                    ->sortable()
                    ->searchable()
                    ->formatStateUsing(fn($record) => $record->purchaseOrder?->PO_Code ?? '-'),

                TextColumn::make('Date_Created')->label('Order Date'),
                TextColumn::make('vendors.CompanyName')->label('Vendor'),
                TextColumn::make('Jumlah')->label('Total'),
            ])->searchable()
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
            'index' => Pages\ListSp3s::route('/'),
            'create' => Pages\CreateSp3::route('/create'),
            'edit' => Pages\EditSp3::route('/{record}/edit'),
        ];
    }
}
