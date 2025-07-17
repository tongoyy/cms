<?php

namespace App\Http\Controllers;

use App\Models\LaporanPettyCash;
use App\Models\PettyCash;
use Illuminate\Http\Request;
use Spatie\Browsershot\Browsershot;

class PettyCash_PdfController extends Controller
{
    public function pdfPC($id)
    {
        // Ambil nomor PO terakhir
        $desc = \App\Models\PettyCash::latest()->value('id') ?? 'PettyCash';
        $nextNumber = str_pad(date('D'), 5, '0', STR_PAD_LEFT);

        // Ambil data Purchase Order beserta itemnya
        $data = PettyCash::with('LaporanPettyCash')->find($id);

        if (!$data || !$data->LaporanPettyCash) {
            abort(404, 'Data or related items not found.');
        }

        // Render tampilan menjadi HTML
        $html = view('PettyCashPDF', compact('data'))->render();

        // Simpan sebagai PDF
        $filename = "#PC-{$nextNumber}_" . $desc . '.pdf';
        Browsershot::html($html)
            ->format('A4') // Pastikan format halaman
            ->save($filename);

        return response()->download($filename);
    }
}
