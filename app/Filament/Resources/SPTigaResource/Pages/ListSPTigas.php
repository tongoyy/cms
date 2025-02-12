<?php

namespace App\Filament\Resources\SPTigaResource\Pages;

use App\Filament\Resources\SPTigaResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListSPTigas extends ListRecords
{
    protected static string $resource = SPTigaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
