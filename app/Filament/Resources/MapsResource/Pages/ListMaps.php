<?php

namespace App\Filament\Resources\MapsResource\Pages;

use App\Filament\Resources\MapsResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;



class ListMaps extends ListRecords
{
    protected static string $resource = MapsResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
