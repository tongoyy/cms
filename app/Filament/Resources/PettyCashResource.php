<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PettyCashResource\Pages;
use App\Filament\Resources\PettyCashResource\RelationManagers;
use App\Models\PettyCash;
use Filament\Forms;
use Filament\Forms\Components;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\Repeater;
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
                Fieldset::make('Petty Cash')
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
                        TextInput::make('Description')
                            ->label('Description'),
                        TextInput::make('SaldoAwal')
                            ->label('Saldo Awal')
                            ->numeric()
                            ->nullable()
                            ->default(function () {
                                $latest = \App\Models\PettyCash::orderByDesc('created_at')->value('SaldoAwal');
                                return $latest ?? 0;
                            }),
                        TextInput::make('SaldoMasuk')
                            ->label('Saldo Masuk')
                            ->numeric()
                            ->nullable(),
                        TextInput::make('SaldoKeluar')
                            ->label('Saldo Keluar')
                            ->numeric()
                            ->nullable(),
                    ])
                    ->columns(5),
                Repeater::make('LaporanPettyCash')
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
                            ->numeric()
                            ->reactive()
                            ->afterStateUpdated(function ($state, callable $set, callable $get) {
                                $hargaSatuan = (float) $get('HargaSatuan');
                                $set('HargaTotal', (float) $state * $hargaSatuan);
                            }),
                        TextInput::make('QuantityText')
                            ->label('Quantity (Unit)'),
                        TextInput::make('Posting')
                            ->label('Posting')
                            ->nullable(),
                        TextInput::make('Keterangan')
                            ->label('Keterangan'),
                        TextInput::make('Kegunaan')
                            ->label('Kegunaan'),
                        TextInput::make('HargaSatuan')
                            ->label('Harga Satuan')
                            ->numeric()
                            ->reactive()
                            ->afterStateUpdated(function ($state, callable $set, callable $get) {
                                $quantityNumber = (float) $get('QuantityNumber');
                                $set('HargaTotal', $quantityNumber * (float) $state);
                            }),
                        TextInput::make('HargaTotal')
                            ->label('Harga Total')
                            ->numeric()
                            ->disabled()
                            ->dehydrated()
                            ->default(
                                fn($get) =>
                                (float) $get('QuantityNumber') * (float) $get('HargaSatuan')
                            ),
                        TextInput::make('Vendor')
                            ->label('Vendor'),
                    ])
                    ->relationship('LaporanPettyCash')
                    ->columns(4)
                    ->columnSpanFull()
                    ->label(new HtmlString('<span class="text-xl font-bold text-gray-800">Laporan Petty Cash</span>'))
                    ->addActionLabel('Tambah Item')
                    ->reorderableWithButtons()
                    ->cloneable()
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('TanggalSaldo')->label('Tanggal'),
                TextColumn::make('SaldoAwal')->label('Saldo'),
                TextColumn::make('SaldoMasuk')->label('Pemasukan'),
                TextColumn::make('SaldoKeluar')->label('Pengeluaran'),
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
            'index' => Pages\ListPettyCashes::route('/'),
            'create' => Pages\CreatePettyCash::route('/create'),
            'edit' => Pages\EditPettyCash::route('/{record}/edit'),
        ];
    }
}
