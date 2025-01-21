<?php

namespace App\Http\Controllers;

use App\Models\PurchaseRequest;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class PdfController extends Controller
{
    public function generatePdf()
    {
        $PR = PurchaseRequest::get();
        $data = [
            'title' => 'Title PDF',
            'date' => date('d/m/y'),
            'PR' => $PR
        ];
        $pdf = Pdf::loadView('generate-user-pdf', $data);
        return $pdf->download('purchase-request.pdf');
    }
}
