<?php

namespace App\Filament\Resources\Sp3Resource\Pages;

use App\Filament\Resources\Sp3Resource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Asmit\ResizedColumn\HasResizableColumn;

class ListSp3s extends ListRecords
{
    use HasResizableColumn;

    protected static string $resource = Sp3Resource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
