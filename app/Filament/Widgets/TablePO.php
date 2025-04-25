<?php

namespace App\Filament\Widgets;

use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class TablePO extends BaseWidget
{
    public function table(Table $table): Table
    {
        return $table
            ->query(\App\Models\PurchaseOrder::query())
            ->columns([
                TextColumn::make('PO_Code')->label('PR Code'),
                TextColumn::make('PO_Name')->label('PR Name'),
                TextColumn::make('vendors.CompanyName')->label('Vendors'),
                TextColumn::make('Order_Date')->label('Order Date')->date('d-M-Y'),
                TextColumn::make('Project')->label('Purchase Type'),
                TextColumn::make('Grand_Total')->formatStateUsing(fn($state) => 'Rp ' . number_format($state, 0, ',', '.')),
            ])->searchable();
    }
}
