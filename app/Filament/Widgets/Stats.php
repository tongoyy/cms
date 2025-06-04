<?php

namespace App\Filament\Widgets;

use App\Models\PurchaseOrder;
use App\Models\PurchaseRequest;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class Stats_PR extends BaseWidget
{
    protected static bool $isLazy = false;

    protected ?string $heading = 'Summary';

    protected ?string $description = 'An overview of some Purchase Request.';

    protected function getStats(): array
    {
        return [
            Stat::make('Purchase Request', PurchaseRequest::count(), 'PR')
                ->description('Total PR')->descriptionIcon('heroicon-o-shopping-cart')
                ->color('success')
                ->extraAttributes([
                    'class' => 'cursor-pointer',
                    'wire:click' => "\$dispatch('setStatusFilter', { filter: 'processed' })",
                ])->chart([50, 150, 10, 200, 500, 410, 170]),
            Stat::make('Purchase Order', PurchaseOrder::count(), 'PR')
                ->description('Total PR')->descriptionIcon('heroicon-o-shopping-cart')
                ->color('success')
                ->extraAttributes([
                    'class' => 'cursor-pointer',
                    'wire:click' => "\$dispatch('setStatusFilter', { filter: 'processed' })",
                ])->chart([50, 150, 10, 200, 500, 410, 170]),
        ];
    }
}
