<?php

namespace App\Http\Controllers;

use App\Models\PurchaseOrder;
use App\Models\PurchaseOrderItem;
use Illuminate\Http\Request;
use Spatie\LaravelPdf\Facades\Pdf;
use Spatie\Browsershot\Browsershot;
use Spatie\LaravelPdf\Enums\Orientation;

class PO_PdfController extends Controller
{
    public function pdfPO($id)
    {
        // Ambil nomor PO terakhir
        $lastNumber = \App\Models\PurchaseOrder::latest()->value('Number') ?? 0;
        $desc = \App\Models\PurchaseOrder::latest()->value('PO_Name') ?? 'PurchaseOrder';
        $nextNumber = str_pad($lastNumber, 5, '0', STR_PAD_LEFT);

        // Ambil data Purchase Order beserta itemnya
        $data = PurchaseOrder::with('purchaseOrderItems')->find($id);

        if (!$data || !$data->purchaseOrderItems) {
            abort(404, 'Data or related items not found.');
        }

        // Render tampilan menjadi HTML
        $html = view('PurchaseOrderPDF', compact('data'))->render();

        // Simpan sebagai PDF
        $filename = "#PO-{$nextNumber}_" . $desc . '.pdf';
        Browsershot::html($html)
            ->landscape() // Pastikan orientasi halaman
            ->landscape()
            ->format('A4')
            ->save($filename);

        return response()->download($filename);
    }
}
