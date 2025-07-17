<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PO_PdfController;
use App\Http\Controllers\PR_PdfController;
use App\Http\Controllers\SP3_PdfController;
use App\Http\Controllers\PettyCash_PdfController;
use App\Http\Controllers\ProfileController;
use LivewireFilemanager\Filemanager\Http\Controllers\Files\FileController;

Route::get('/', function () {
    return redirect()->route('filament.admin.auth.login');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// routes/web.php
Route::get('/pdfPR/{id}', [PR_PdfController::class, 'pdfPR'])->name('pdfPR');

Route::get('/pdfPO/{id}', [PO_PdfController::class, 'pdfPO'])->name('pdfPO');

Route::get('/pdfSP3/{id}', [SP3_PdfController::class, 'pdfSP3'])->name('pdfSP3');

Route::get('/pdfPC/{id}', [PettyCash_PdfController::class, 'pdfPC'])->name('pdfPC');

Route::get('{path}', [FileController::class, 'show'])->where('path', '.*')->name('assets.show');

require __DIR__ . '/auth.php';
