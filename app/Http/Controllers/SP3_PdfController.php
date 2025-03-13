<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Browsershot\Browsershot;
use App\Models\PurchaseRequest;
use App\Models\PurchaseOrder;
use App\Models\sp3;

// class SP3_PdfController extends Controller
// {
//     public function pdfSP3($id)
//     {
//         // Ambil data SP3 dari database, sekaligus relasinya
//         $sp3 = Sp3::with(['purchaseRequestItems', 'purchaseOrderItems'])->findOrFail($id);

//         // Render Blade template ke HTML
//         // Pastikan Anda sudah membuat file Blade "pdf/sp3.blade.php"
//         $html = view('pdfSP3', compact('sp3'))->render();

//         // Tentukan path penyimpanan PDF (bisa di /storage/app/public atau sesuai kebutuhan)
//         $pdfPath = storage_path("app/public/sp3-{$id}.pdf");

//         // Gunakan Browsershot untuk menghasilkan PDF
//         Browsershot::html($html)
//             ->format('A4')
//             ->margins(10, 10, 10, 10) // margin optional
//             ->savePdf($pdfPath);

//         // Opsional: langsung unduh file PDF
//         return response()->download($pdfPath, "SP3-{$id}.pdf");
//     }
// }

class SP3_PdfController extends Controller
{
    public function pdfSP3($id)
    {
        // Ambil data SP3 beserta relasinya
        $sp3 = Sp3::with(['purchaseRequestItems', 'purchaseOrderItems'])->findOrFail($id);

        // Pilih view sesuai kondisi:
        // Jika Purchase_Request tidak kosong, render view untuk purchase request items
        if (!empty($sp3->Purchase_Request)) {
            $html = view('sp3_pr', compact('sp3'))->render();
            // Tentukan path penyimpanan PDF
            $pdfPath = storage_path("app/public/sp3-{$id}.pdf");

            // Gunakan Browsershot untuk menghasilkan PDF dari HTML yang sudah dirender
            Browsershot::html($html)
                ->format('A4')
                ->margins(0, 0, 0, 0)
                ->savePdf($pdfPath);
        }
        // Jika Purchase_Request kosong dan Purchase_Order tidak kosong, render view untuk purchase order items
        elseif (!empty($sp3->Purchase_Order)) {
            $html = view('sp3_po', compact('sp3'))->render();
            // Tentukan path penyimpanan PDF
            $pdfPath = storage_path("app/public/sp3-{$id}.pdf");

            // Gunakan Browsershot untuk menghasilkan PDF dari HTML yang sudah dirender
            Browsershot::html($html)
                ->format('A4')
                ->margins(10, 10, 10, 10)
                ->savePdf($pdfPath);
        }

        // Langsung unduh file PDF yang dihasilkan
        return response()->download($pdfPath, "SP3-{$id}.pdf");
    }
}
