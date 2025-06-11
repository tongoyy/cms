<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PettyCashResource\Pages;
use App\Filament\Resources\PettyCashResource\RelationManagers;
use App\Models\PettyCash;
use Filament\Forms;
use Filament\Forms\Components;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

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
                Repeater::make('pettyCashes')
                    ->label('Laporan Pengeluaran Petty Cash')
                    ->schema([
                        DateTimePicker::make('Tanggal')
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
                            ->label('Saldo')
                            ->numeric(),
                        TextInput::make('SaldoMasuk')
                            ->label('Masuk')
                            ->numeric(),
                        TextInput::make('SaldoKeluar')
                            ->label('Keluar')
                            ->numeric(),
                        TextInput::make('QuantityText')
                            ->label('Quantity Text'),
                        TextInput::make('Posting')
                            ->label('Posting'),
                        TextInput::make('Keterangan')
                            ->label('Keterangan'),
                        TextInput::make('Kegunaan')
                            ->label('Kegunaan'),
                        TextInput::make('HargaSatuan')
                            ->label('Harga Satuan')
                            ->numeric(),
                        TextInput::make('HargaTotal')
                            ->label('Harga Total')
                            ->numeric(),
                        TextInput::make('Vendor')
                            ->label('Vendor'),
                    ])->columns(3)
                    ->columnSpanFull()
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                //
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
