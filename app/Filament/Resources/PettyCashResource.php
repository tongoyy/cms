<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PettyCashResource\Pages;
use App\Filament\Resources\PettyCashResource\RelationManagers;
use App\Models\PettyCash;
use Filament\Tables\Actions\ActionGroup;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\ViewAction;
use Filament\Forms;
use Filament\Forms\Components;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Support\Enums\Alignment;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\HtmlString;
use Filament\Tables\Grouping\Group;
use Filament\Forms\Components\Wizard;


class PettyCashResource extends Resource
{
    protected static ?string $model = PettyCash::class;

    protected static ?string $navigationIcon = 'heroicon-o-currency-dollar';

    protected static ?string $navigationLabel = 'Petty Cash';

    protected static ?string $navigationGroup = 'Purchasing';

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                DateTimePicker::make('TanggalSaldo')
                    ->label('Tanggal')
                    ->native(false)
                    ->firstDayOfWeek(1)
                    ->closeOnDateSelection()
                    ->timezone('Asia/Jakarta')
                    ->locale('id')
                    ->displayFormat('D, d-M-Y H:i:s')
                    ->default(now()),

                TextInput::make('SaldoAwal')
                    ->label('Saldo Awal')
                    ->prefix('Rp ')
                    ->default(function () {
                        $latest = \App\Models\PettyCash::latest('TanggalSaldo')->first();
                        return $latest ? $latest->SaldoAwal : 0;
                    })
                    ->numeric()
                    ->nullable()
                    ->live()
                    ->debounce(500)
                    ->currencyMask(thousandSeparator: ',', decimalSeparator: '.', precision: 2),

                TextInput::make('SaldoMasuk')
                    ->label('Saldo Masuk')
                    ->prefix('Rp ')
                    ->default(0)
                    ->numeric()
                    ->nullable()
                    ->live()
                    ->debounce(3000)
                    ->currencyMask(thousandSeparator: ',', decimalSeparator: '.', precision: 2),

                TextInput::make('SaldoKeluar')
                    ->label('Pengeluaran')
                    ->prefix('Rp ')
                    ->default(0)
                    ->numeric()
                    ->nullable()
                    ->live()
                    ->debounce(3000)
                    ->currencyMask(thousandSeparator: ',', decimalSeparator: '.', precision: 2),

                TextInput::make('JudulLaporan')
                    ->label('Judul Laporan')
                    ->default(''),

                Select::make('JenisLaporan')
                    ->label('Jenis Laporan')
                    ->options([
                        'Mess Jakarta' => 'Mess Jakarta',
                        'Lapangan' => 'Lapangan',
                        'Sukowati' => 'Sukowati',
                        'Beringin' => 'Beringin',
                    ]),

                Repeater::make('LaporanPettyCash')
                    ->relationship('LaporanPettyCash')
                    ->schema([
                        DateTimePicker::make('TanggalLaporan')
                            ->label('Tanggal')
                            ->native(false)
                            ->firstDayOfWeek(1)
                            ->closeOnDateSelection()
                            ->timezone('Asia/Jakarta')
                            ->locale('id')
                            ->displayFormat('D, d-M-Y H:i:s')
                            ->default(now())
                            ->hidden(),
                        TextInput::make('QuantityNumber')
                            ->label('Quantity (Jumlah)')
                            ->nullable()
                            ->numeric()
                            ->reactive()
                            ->debounce(500)
                            ->afterStateUpdated(function ($state, callable $set, callable $get) {
                                $hargaSatuan = (float) $get('HargaSatuan');
                                $set('HargaTotal', (float) $state * $hargaSatuan);
                            }),
                        TextInput::make('QuantityText')
                            ->label('Quantity (Unit)')
                            ->nullable(),
                        TextInput::make('Posting')
                            ->label('Posting')
                            ->nullable(),
                        TextInput::make('Keterangan')
                            ->label('Keterangan')
                            ->nullable(),
                        TextInput::make('Kegunaan')
                            ->label('Kegunaan')
                            ->nullable(),
                        TextInput::make('HargaSatuan')
                            ->label('Harga Satuan')
                            ->nullable()
                            ->numeric()
                            ->currencyMask(thousandSeparator: ',', decimalSeparator: '.', precision: 2)
                            ->reactive()
                            ->debounce(1000)
                            ->afterStateUpdated(function ($state, callable $set, callable $get) {
                                $quantityNumber = (float) $get('QuantityNumber');
                                $set('HargaTotal', $quantityNumber * (float) $state);
                            }),
                        TextInput::make('HargaTotal')
                            ->label('Harga Total')
                            ->numeric()
                            ->currencyMask(thousandSeparator: ',', decimalSeparator: '.', precision: 2)
                            ->default(
                                fn($get) =>
                                (float) $get('QuantityNumber') * (float) $get('HargaSatuan')
                            )
                            ->reactive()
                            ->debounce(3000)
                            ->afterStateUpdated(function ($state, callable $set, callable $get) {
                                // Hitung total HargaTotal dari semua item di repeater
                                $laporan = $get('../../LaporanPettyCash') ?? [];
                                $totalKeluar = 0;
                                foreach ($laporan as $item) {
                                    $totalKeluar += (float) ($item['HargaTotal'] ?? 0);
                                }
                                $set('../../SaldoKeluar', $totalKeluar);
                                $set('../../TotalPengeluaran', $totalKeluar);
                            }),
                        TextInput::make('Vendor')
                            ->label('Vendor'),
                    ])
                    ->columns(4)
                    ->columnSpanFull()
                    ->label(new HtmlString('<span class="text-xl font-bold text-gray-800">Laporan Petty Cash</span>'))
                    ->addActionLabel('Tambah Item')
                    ->reorderableWithButtons()
                    ->cloneable(),

                TextInput::make('TotalPengeluaran')
                    ->label('Total Pengeluaran')
                    ->prefix('Rp ')
                    ->numeric()
                    ->disabled()
                    ->default(0)
                    ->reactive()
                    ->debounce(1000)
                    ->afterStateHydrated(function ($set, $get) {
                        $laporan = $get('LaporanPettyCash') ?? [];
                        $total = 0;
                        foreach ($laporan as $item) {
                            $total += (float) ($item['HargaTotal'] ?? 0);
                        }
                        $set('TotalPengeluaran', $total);
                    })
                    ->currencyMask(thousandSeparator: ',', decimalSeparator: '.', precision: 2)->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            // Mengelompokkan Data berdasarkan tanggal
            ->groups([
                Group::make('TanggalSaldo')
                    ->label('Tanggal')
                    ->date()->collapsible(),
            ])
            ->columns([
                TextColumn::make('TanggalSaldo')->label('Tanggal')->date('d-M-Y'),
                TextColumn::make('SaldoAwal')->label('Saldo')->formatStateUsing(fn($state) => 'Rp ' . number_format($state, 0, ',', '.')),
                TextColumn::make('SaldoMasuk')->label('Pemasukan')->formatStateUsing(fn($state) => 'Rp ' . number_format($state, 0, ',', '.')),
                TextColumn::make('SaldoKeluar')->label('Pengeluaran')->formatStateUsing(fn($state) => 'Rp ' . number_format($state, 0, ',', '.')),
            ])
            ->filters([
                //
            ])
            ->actions([
                ActionGroup::make([
                    ViewAction::make(),
                    EditAction::make(),
                    DeleteAction::make(),
                    Tables\Actions\Action::make('pdf')
                        ->icon('heroicon-o-document-arrow-down')
                        ->url(fn(PettyCash $record) => route('pdfPC', $record))
                        ->openUrlInNewTab()
                        ->label('PDF')
                        ->color('success'),
                ])->icon('heroicon-o-bars-3'),
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
            'index' => Pages\ListPettyCashes::route('/'),
            'create' => Pages\CreatePettyCash::route('/create'),
            'edit' => Pages\EditPettyCash::route('/{record}/edit'),
        ];
    }
}
