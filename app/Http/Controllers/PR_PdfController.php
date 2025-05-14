<?php

namespace App\Http\Controllers;

use App\Models\PurchaseOrder;
use App\Models\PurchaseRequest;
use Barryvdh\DomPDF\Facade\Pdf;
use Spatie\Browsershot\Browsershot;

class PR_PdfController extends Controller
{

    public function pdfPR($id)
    {

        $lastNumber = \App\Models\PurchaseRequest::latest()->value('Number') ?? 0;
        $desc = \App\Models\PurchaseRequest::latest()->value('PR_Code') ?? 'PurchaseRequest';

        // 1. Retrieve the data based on the ID.
        // $data = PurchaseRequest::find($id); // Or YourModel::findOrFail($id)
        $data = PurchaseRequest::with('purchaseRequestItems')->find($id);

        /* Items Detail PDF */
        if (!$data || !$data->purchaseRequestItems) {
            abort(404, 'Data or related items not found.');
        }

        // 2. Pass the data to a view.
        // $pdf = PDF::loadView('PurchaseRequestPDF', compact('data')); // 'pdf.invoice' is the name of your view.
        $filename = $desc . '.pdf';
        $html = view('PurchaseRequestPDF', compact('data'))->render();
        Browsershot::html($html)
            ->save($filename);
        return response()->download($filename);
        // 3. (Optional) Set PDF options (e.g., orientation, paper size).
        // $pdf->setOptions(['defaultFont' => 'sans-serif']);

        // 4. Return the PDF as a download or inline.
        // return $pdf->download('#PR-000' . $id . '.pdf'); // Download the PDF.
        // return $pdf->stream('invoice_' . $id . '.pdf'); // Display the PDF in the browser.

    }
}
