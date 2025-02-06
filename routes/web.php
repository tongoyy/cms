<?php

// use App\Http\Controllers\DownloadPdfController;

use App\Http\Controllers\DownloadPdfController;
use App\Http\Controllers\PdfController;
use App\Models\PurchaseRequest;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Route;
use Spatie\Browsershot\Browsershot;

Route::get('/', function () {
    return view('welcome');
});

// routes/web.php
Route::get('/pdf/{id}', [PdfController::class, 'generatePdf'])->name('PdfDownload');

// Route::get('PdfDownload', function () {
//     $html = view('pdfs.PurchaseRequestPDF')->render();

//     $pdf = Browsershot::html($html)
//         ->setIncludePath('services.browsershort.include_path')
//         ->pdf();

//     // return new Response($pdf, 200, [
//     //     'Content-Type' => 'application/pdf',
//     //     'Content-Disposition' => 'attachment; filename="example.pdf"',
//     //     'Content-Length' => strlen($pdf)
//     // ]);

//     return new Response($pdf, 200, [
//         'Content-Type' => 'application/pdf',
//         'Content-Disposition' => 'inline; filename="Purchase Request.pdf"',
//     ]);
// })->name('PdfDownload');

// Route::get('pdf', ['App\Http\Controllers\PdfController'::class, 'generatePdf']);

// Route::get('/{record}/pdf', function ($record) {
//     return view('pdf', compact($record));
// });

// Route::get('/{record}/pdf', [DownloadPdfController::class, 'download'])->name('purchase.pdf.download');
// Route::get('pdf', [PdfController::class, 'generatePdf'])->name('purchase.pdf.download');

// Route::get('/{record}/pdf', [DownloadPdfController::class, 'download'])->name('purchase_request.pdf.download');
