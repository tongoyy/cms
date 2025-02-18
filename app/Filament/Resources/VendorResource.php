<?php

namespace App\Filament\Resources;

use App\Filament\Resources\VendorResource\Pages;
use App\Filament\Resources\VendorResource\RelationManagers;
use App\Models\Vendor;
use App\Models\Vendors;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\Action;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class VendorResource extends Resource
{
    protected static ?string $model = Vendors::class;

    protected static ?string $navigationIcon = 'heroicon-o-users';

    protected static ?string $navigationLabel = 'Vendors';

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }

    protected static ?string $navigationGroup = 'Purchasing';

    public static function form(Form $form): Form
    {
        $number = Vendors::latest()->value('Number');
        return $form
            ->schema([
                TextInput::make('VendorCode')->label('Vendor Code')->required()
                    ->label('Vendor Code')
                    ->default(function () {
                        $lastNumber = \App\Models\Vendors::latest()->value('Number') ?? 0;
                        $nextNumber = str_pad($lastNumber + 1, 3, '0', STR_PAD_LEFT);
                        return "VC-" . $nextNumber++;
                    })
                    ->readOnly(),
                Hidden::make('Number')->default($number++),
                TextInput::make('CompanyName')->label('Company Name')->required(),
                TextInput::make('NPWP')->label('NPWP')->required(),
                TextInput::make('Phone')->label('Phone')->required()->numeric(),
                TextInput::make('Email')->label('Email')->required()->email(),
                Textarea::make('Address')->label('Address')->required(),
                TextInput::make('RekeningBank')->label('Rekening Bank')->required(),
                TextInput::make('NomorRekening')->label('Nomor Rekening')->required()->numeric(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('VendorCode')->label('Vendor Code'),
                TextColumn::make('CompanyName')->label('Company Name'),
                TextColumn::make('NPWP')->label('NPWP'),
                TextColumn::make('Phone')->label('Phone'),
                TextColumn::make('Email')->label('Email'),
                TextColumn::make('Address')->label('Address'),
                TextColumn::make('RekeningBank')->label('RekeningBank'),
                TextColumn::make('NomorRekening')->label('Nomor Rekening'),
            ])->searchable()
            ->emptyStateHeading('Belum ada Data Vendor!')
            ->emptyStateDescription('Silahkan tambahkan Vendor')
            ->emptyStateIcon('heroicon-o-users')
            ->emptyStateActions([
                Action::make('create')
                    ->label('Tambahkan Vendor')
                    ->url(route('filament.admin.resources.vendors.create'))
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
            'index' => Pages\ListVendors::route('/'),
            'create' => Pages\CreateVendor::route('/create'),
            'edit' => Pages\EditVendor::route('/{record}/edit'),
        ];
    }
}
