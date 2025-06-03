<?php

namespace App\Filament\Resources\MapsResource\Pages;

use App\Filament\Resources\MapsResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditMaps extends EditRecord
{
    protected static string $resource = MapsResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
