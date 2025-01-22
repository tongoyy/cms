<?php

// use App\Http\Controllers\DownloadPdfController;
use App\Http\Controllers\PdfController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});
// Route::get('pdf', ['App\Http\Controllers\PdfController'::class, 'generatePdf']);

// Route::get('/{record}/pdf', function ($record) {
//     return view('pdf', compact($record));
// });

// Route::get('/{record}/pdf', [DownloadPdfController::class, 'download'])->name('purchase.pdf.download');
Route::get('pdf', [PdfController::class, 'generatePdf'])->name('purchase.pdf.download');
