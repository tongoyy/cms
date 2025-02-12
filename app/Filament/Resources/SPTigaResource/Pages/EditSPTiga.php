<?php

namespace App\Filament\Resources\SPTigaResource\Pages;

use App\Filament\Resources\SPTigaResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditSPTiga extends EditRecord
{
    protected static string $resource = SPTigaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
