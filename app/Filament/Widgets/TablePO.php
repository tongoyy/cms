<?php

namespace App\Filament\Widgets;

use Filament\Support\Enums\FontWeight;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class TablePO extends BaseWidget
{
    protected static ?string $heading = 'Purchase Order';
    public function table(Table $table): Table
    {
        return $table
            ->query(\App\Models\PurchaseOrder::query())
            ->columns([
                TextColumn::make('PO_Code')->label('PO Code')->searchable()->weight(FontWeight::Bold)->toggleable()->color('info'),
                TextColumn::make('PO_Name')->label('PO Name')->searchable()->size(TextColumn\TextColumnSize::ExtraSmall)->toggleable(),
                TextColumn::make('vendors.CompanyName')->label('Vendors')->searchable()->toggleable(),
                TextColumn::make('Order_Date')->label('Order Date')->date('d/M/Y')->searchable()->toggleable(),
                TextColumn::make('Project')->label('Project')->searchable()->toggleable(),
                TextColumn::make('Grand_Total')->formatStateUsing(fn($state) => 'Rp ' . number_format($state, 0, ',', '.'))->searchable()->toggleable(),
            ])->defaultPaginationPageOption(2)->paginated([2, 10, 25, 50, 100, 'all'])->searchDebounce('50ms');
    }
}
