<?php

namespace App\Filament\Resources\PettyCashResource\Pages;

use App\Filament\Resources\PettyCashResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreatePettyCash extends CreateRecord
{
    protected static string $resource = PettyCashResource::class;
    protected static bool $canCreateAnother = false;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
