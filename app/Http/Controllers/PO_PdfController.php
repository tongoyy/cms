<?php

namespace App\Http\Controllers;

use App\Models\PurchaseOrder;
use App\Models\PurchaseOrderItem;
use Illuminate\Http\Request;
use Spatie\Browsershot\Browsershot;

class PO_PdfController extends Controller
{
    public function pdfPO($id)
    {
        // 1. Retrieve the data based on the ID.
        // $data = PurchaseRequest::find($id); // Or YourModel::findOrFail($id)
        $data = PurchaseOrder::with('purchaseOrderItems')->find($id);

        if (!$data || !$data->purchaseOrderItems) {
            abort(404, 'Data or related items not found.');
        }

        // 2. Pass the data to a view.
        // $pdf = PDF::loadView('PurchaseRequestPDF', compact('data')); // 'pdf.invoice' is the name of your view.

        $html = view('PurchaseOrderPDF', compact('data'))->render();
        Browsershot::html($html)
            ->save('#PO-0000' . $id . '.pdf');
        return response()->download('#PO-0000' . $id . '.pdf');
        // 3. (Optional) Set PDF options (e.g., orientation, paper size).

        // 4. Return the PDF as a download or inline.
        // return $pdf->download('#PR-000' . $id . '.pdf'); // Download the PDF.
        // return $pdf->stream('invoice_' . $id . '.pdf'); // Display the PDF in the browser.
    }
}
