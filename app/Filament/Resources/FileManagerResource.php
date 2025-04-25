<?php

namespace App\Filament\Resources;

use App\Filament\Resources\FileManagerResource\Pages;
use App\Filament\Resources\FileManagerResource\RelationManagers;
use App\Models\FileManager;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Storage;
use TomatoPHP\FilamentMediaManager\Facade\FilamentMediaManager;

class FileManagerResource extends Resource
{
    protected static ?string $model = FileManager::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                // Field lainnya
                FilamentMediaManager::make('file')  // Nama kolom yang menyimpan file
                    ->label('File Manager')
                    ->image()  // Anda bisa menghapus ini jika ingin mendukung semua jenis file
                    ->disk('public')  // Tentukan disk yang digunakan (public, s3, dll.)
                    ->directory('uploads') // Tentukan folder penyimpanan di disk
                    ->multiple(), // Menyediakan kemampuan untuk memilih beberapa file sekaligus
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title'),
                TextColumn::make('file')
                    ->label('File')
                    ->formatStateUsing(fn($state) => $state ? '<a href="' . Storage::disk('public')->url($state) . '" target="_blank">View File</a>' : 'No File')
                    ->html(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListFileManagers::route('/'),
            'create' => Pages\CreateFileManager::route('/create'),
            'edit' => Pages\EditFileManager::route('/{record}/edit'),
        ];
    }
}
