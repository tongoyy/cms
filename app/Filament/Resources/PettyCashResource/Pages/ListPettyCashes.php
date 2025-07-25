<?php

namespace App\Filament\Resources\PettyCashResource\Pages;

use App\Filament\Resources\PettyCashResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListPettyCashes extends ListRecords
{
    protected static string $resource = PettyCashResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    public function setPage($page, $pageName = 'page'): void
    {
        parent::setPage($page, $pageName);

        $this->dispatch('scroll-to-top');
    }
}
