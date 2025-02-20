<?php

namespace App\Http\Controllers;

use App\Models\PurchaseOrder;
use App\Models\PurchaseRequest;
use Barryvdh\DomPDF\Facade\Pdf;
use Doctrine\DBAL\Schema\View;
use Spatie\Browsershot\Browsershot;

class PR_PdfController extends Controller
{

    public function pdfPR($id)
    {
        // 1. Retrieve the data based on the ID.
        // $data = PurchaseRequest::find($id); // Or YourModel::findOrFail($id)
        $data = PurchaseRequest::with('purchaseRequestItems')->find($id);

        /* Items Detail PDF */
        if (!$data || !$data->purchaseRequestItems) {
            abort(404, 'Data or related items not found.');
        }

        // 2. Pass the data to a view.
        // $pdf = PDF::loadView('PurchaseRequestPDF', compact('data')); // 'pdf.invoice' is the name of your view.

        $html = view('PurchaseRequestPDF', compact('data'))->render();
        Browsershot::html($html)
            ->save('#PR-0000' . $id . '.pdf');
        return response()->download('#PR-0000' . $id . '.pdf');
        // 3. (Optional) Set PDF options (e.g., orientation, paper size).
        // $pdf->setOptions(['defaultFont' => 'sans-serif']);

        // 4. Return the PDF as a download or inline.
        // return $pdf->download('#PR-000' . $id . '.pdf'); // Download the PDF.
        // return $pdf->stream('invoice_' . $id . '.pdf'); // Display the PDF in the browser.

    }

    // public function generatePdf()
    // {
    //     // 1. Retrieve the Data (Most Important Part)
    //     $data = PurchaseRequest::all(); // Or any other query you need
    //     // Example: Retrieve specific data
    //     // $data = YourModel::where('status', 'active')->get();
    //     // Example: Retrieve with relationships
    //     // $data = YourModel::with('relatedModel')->find(1);

    //     // Example: If you need to pass data as an array, transform it
    //     $dataArray = $data->toArray();

    //     // 2. Pass Data to the View (Using with or compact)
    //     $html = view('PurchaseRequestPDF', ['data' => $data])->render(); // Pass the collection directly
    //     // or if you transformed the data to array
    //     $html = view('PurchaseRequestPDF', ['data' => $dataArray])->render();


    //     // 3. (Optional) Save HTML for debugging
    //     // file_put_contents('debug.html', $html); // Uncomment to save HTML

    //     // 4. Generate PDF with Browsershot
    //     Browsershot::html($html)
    //         ->save('Purchase Request.pdf');

    //     return response()->download('Purchase Request.pdf'); // Return the PDF as a download
    // }

    // public function generatePdf()
    // {
    //     $PR = PurchaseRequest::get();
    //     $data = [
    //         'title' => 'Title PDF',
    //         'date' => date('d/m/y'),
    //         'PR' => $PR,
    //         'images' => public_path('images/aiweb.png')
    //     ];
    //     $pdf = Pdf::loadView('PurchaseRequest', $data);
    //     return $pdf->download('PurchaseRequest.pdf');
    // }
}
