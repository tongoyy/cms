<?php

namespace App\Filament\Widgets;

use Filament\Forms\Components\Builder;
use Filament\Forms\Components\DatePicker;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class TablePR extends BaseWidget
{

    public function table(Table $table): Table
    {
        return $table
            ->query(\App\Models\PurchaseRequest::query())
            ->columns([
                TextColumn::make('PR_Code')->label('PR Code')->visibleFrom('md'),
                TextColumn::make('PR_Name')->label('PR Name'),
                TextColumn::make('Project'),
                TextColumn::make('Department'),
                TextColumn::make('DueDate')->label('Due Date')->date('d-M-Y'),
                TextColumn::make('GrandTotal')->formatStateUsing(fn($state) => 'Rp ' . number_format($state, 0, ',', '.')),
            ])->searchable();
    }
}
