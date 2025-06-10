<?php

namespace App\Filament\Widgets;

use Filament\Support\Enums\FontWeight;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class TablePR extends BaseWidget
{
    protected static ?string $heading = 'Purchase Request';
    public function table(Table $table): Table
    {
        return $table
            ->query(\App\Models\PurchaseRequest::query())
            ->columns([
                TextColumn::make('PR_Code')->label('PR Code')->searchable()->weight(FontWeight::Bold)->toggleable()->color('info'),
                TextColumn::make('PR_Name')->label('PR Name')->searchable()->size(TextColumn\TextColumnSize::ExtraSmall)->toggleable(),
                TextColumn::make('Project')->searchable()->toggleable(),
                TextColumn::make('Department')->searchable()->toggleable(),
                TextColumn::make('DueDate')->label('Due Date')->date('d/M/Y')->searchable()->toggleable(),
                TextColumn::make('GrandTotal')->formatStateUsing(fn($state) => 'Rp ' . number_format($state, 0, ',', '.'))->searchable()->toggleable(),
            ])->defaultPaginationPageOption(2)->paginated([2, 10, 25, 50, 100, 'all'])->searchDebounce('50ms');
    }
}
