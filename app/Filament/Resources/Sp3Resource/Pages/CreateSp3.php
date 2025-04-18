<?php

namespace App\Filament\Resources\Sp3Resource\Pages;

use App\Filament\Resources\Sp3Resource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateSp3 extends CreateRecord
{
    protected static string $resource = Sp3Resource::class;
    protected static bool $canCreateAnother = false;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
