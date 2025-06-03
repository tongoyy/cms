<?php

namespace App\Filament\Resources;

use App\Filament\Resources\MapsResource\Pages;
use App\Filament\Resources\MapsResource\RelationManagers;
use App\Models\Maps;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Afsakar\LeafletMapPicker\LeafletMapPicker;
use Afsakar\LeafletMapPicker\LeafletMapPickerEntry;

class MapsResource extends Resource
{
    protected static ?string $model = Maps::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                LeafletMapPicker::make('location')
                    ->label('PT Audemars Indonesia')
                    ->height('600px')
                    ->defaultLocation([-6.24408197904727, 106.82114501673226]) // Istanbul coordinates
                    ->defaultZoom(15)
                    ->draggable() // default true
                    ->clickable() // default true
                    ->myLocationButtonLabel('Go to My Location')
                    ->tileProvider('google') // default options: openstreetmap, google, googleSatellite, googleTerrain, googleHybrid, esri
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
            'index' => Pages\ListMaps::route('/'),
            'create' => Pages\CreateMaps::route('/create'),
            'edit' => Pages\EditMaps::route('/{record}/edit'),
        ];
    }
}
