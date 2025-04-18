@php
    $image = public_path() . '/images/logo.jpg';
@endphp

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Surat Permintaan Proses Pembayaran</title>
    <style>
        .containers {
            font-family: Arial, sans-serif;
            margin: 20px;
            font-size: 12px;
        }

        .containers {
            width: 92%;
            margin: auto;
            border: 1px solid black;
        }

        .container-header {
            display: flex;
            justify-content: space-between;
            border: 1px solid black;
        }

        .container-doc-info {
            display: flex;
            border: 1px solid black;
            width: 27.5%;
            padding: 1%;
            font-size: 10px;
        }

        .docs-info {
            display: flex;
            justify-content: space-between;
            font-size: 9px;
        }

        .text-infos td {
            padding-bottom: 5%;
        }

        .header {
            display: flex;
            font-weight: bold;
            justify-content: center;
            text-align: center;
            align-items: center;
            width: 45%;
            font-size: 13px;
            border: 1px solid black;
        }

        .logo {
            text-align: left;
            border: 1px solid black;
            width: 27.5%;
            display: flex;
            justify-content: center;
        }

        .info-table {
            width: 100%;
            border: 1px solid black;
            border-collapse: collapse;
        }

        .info-table td {
            border: none;
        }

        .info-table-content {
            display: flex;
        }

        .info-table {
            width: 100%;
            border-collapse: collapse;
        }

        .info-table td,
        .payment-info-table td,
        .payment-table td {
            padding: 5px;
        }

        .payment-table {
            width: 70%;
            border-collapse: collapse;
        }

        .payment-tyoe tr,
        .payment-tyoe td {
            margin: 0 !important;
            padding: 0 !important;
            border-spacing: 0;
        }

        .bold {
            font-weight: bold;
        }

        .bolds {
            font-weight: bold;
            width: 15px;
        }

        .signature {
            display: flex;
            justify-content: space-between;
            margin-top: 42px;
        }

        .signature div {
            text-align: center;
            width: 30%;
        }

        .payment-table-details {
            width: 100%;
            border-collapse: collapse;
        }

        .payment-table-details td {
            padding: 5px;
        }

        .payment-table-details .bold {
            font-weight: bold;
        }

        .payment-table-details td:first-child {
            text-align: left;
        }

        .payment-table-details td:nth-child(2) {
            text-align: left;
            width: 75px;
        }

        .payment-table-details td:nth-child(2):before {
            font-weight: normal;
        }

        .payment-table-details .underline {
            border-bottom: 1px solid black;
            margin-top: 2rem;
            margin-bottom: 1rem;
            margin-left: 50px;
            display: block;
            width: 25%;
        }
    </style>
</head>

<body>
    <div class="containers">
        <div class="container-header">
            <div class="logo" style="vertical-align: middle;">
                <img src="<?php echo $image; ?>" alt="Audemars Indonesia" width="130" height="75"
                    style="vertical-align: middle;">
            </div>
            <div class="header">SURAT PERMINTAAN PROSES PEMBAYARAN</div>
            <div class="container-doc-info">
                <table class="docs-info">
                    <tr class="text-infos">
                        <td>Nomor Dokumen :</td>
                        <td>AMI-F-FIN-P-01/01</td>
                    </tr>
                    <tr class="text-infos">
                        <td>Revisi :</td>
                        <td>02</td>
                    </tr>
                    <tr class="text-infos">
                        <td>Tanggal Terbit :</td>
                        <td>{{ \Carbon\Carbon::now()->locale('id')->translatedFormat('j F Y') }}</td>
                    </tr>
                </table>
            </div>
        </div>
        @if ($sp3)
            <table class="info-table" style="padding: 10px 0;">
                <tbody>
                    <tr>
                        <td></td>
                    </tr>
                    <tr>
                        <td class="bold" width="100">SPPP No</td>
                        <td> : {{ $sp3->SP3_Number }}</td>
                    </tr>
                    <tr>
                        <td class="bold">Date</td>
                        <td>: {{ \Carbon\Carbon::now()->locale('id')->translatedFormat('j F Y') }}</td>
                    </tr>
                    <tr>
                        <td class="bold">To</td>
                        <td>:</td>
                    </tr>
                    <tr>
                        <td class="bold">Fax</td>
                        <td>:</td>
                        <td class="bold" width="100">Pemakaian</td>
                        <td>: </td>
                    </tr>
                    <tr>
                        <td class="bold">Dari</td>
                        <td>:</td>
                        <td class="bold">Lokasi</td>
                        <td>: Cibitung</td>
                    </tr>
                    <tr>
                        <td></td>
                    </tr>
                </tbody>
            </table>
        @else
        @endif

        @if ($sp3)
            <table class="payment-tyoe">
                <tr>
                    <td class="bold"><strong>Jenis Pembayaran</strong></td>
                    <td> : {{ $sp3->Jenis_Pembayaran }}</td>
                </tr>
            </table>
            <br>
            <p>Terlampir kami kirim dokumen pendukung pembayaran antara lain :</p>

            <div style="display: flex;">
                <table class="payment-info-table" style="white-space: nowrap;">
                    <tr>
                        <td class="bold">1. Nama Supplier</td>
                        <td style="padding-right: 5rem;">: &nbsp; {{ $sp3->Nama_Supplier }}</td>
                    </tr>
                    <tr>
                        <td class="bold">2. No. Invoice</td>
                        <td>: &nbsp; {{ $sp3->No_Invoice }}</td>
                    </tr>
                    <tr>
                        <td class="bold">3. No. Kwitansi</td>
                        <td>: &nbsp; {{ $sp3->No_Kwitansi }} </td>
                    </tr>
                    <tr>
                        <td class="bold">4. No. Purchase Order</td>
                        <td>: &nbsp; {{ $sp3->purchaseRequest->PR_Code }}</td>
                    </tr>
                    <tr>
                        <td class="bold">5. No. Delivery Order</td>
                        <td>: &nbsp; {{ $sp3->No_DO }} </td>
                    </tr>
                    <tr>
                        <td class="bold">6. No. Faktur Pajak</td>
                        <td>: &nbsp; {{ $sp3->No_FP }}</td>
                    </tr>
                    <tr>
                        <td class="bold">7. Masa SSP</td>
                        <td>: &nbsp; {{ $sp3->Tanggal_FP }}</td>
                    </tr>
                </table>
            </div>
        @else
        @endif

        @if ($sp3)
            <table style="padding: 0px 25px 0px 0px;">
                <tr>
                    <td class="bold" style="white-space: nowrap; padding: 0px 25px 0px 0px;">Untuk Pembayaran</td>
                    <td> : &nbsp; {{ $sp3->Untuk_Pembayaran }} </td>
                </tr>
            </table>

            <table class="payment-table-details">
                <tr>
                    <td class="bolds" style="width: 30%;">Amount</td>
                    <td style="width: 12%;">Rp </td>
                    <td style="width: 50%;">{{ number_format($sp3->Amount, 0, ',', '.') }}</td>
                </tr>
                <tr>
                    <td class="bolds">PPN 11%</td>
                    <td>Rp </td>
                    <td></td>
                </tr>
                <tr>
                    <td class="bolds">PPH 23 (2%)</td>
                    <td>Rp </td>
                    <td></td>
                </tr>
                <tr>
                    <td class="bolds">Discount</td>
                    <td>Rp </td>
                    <td class="underline" style="margin-left: -26px; width: 75px;"> </td>
                </tr>
                <tr>
                    <td class=" bolds">Jumlah Total</td>
                    <td>Rp </td>
                    <td>{{ number_format($sp3->Jumlah, 0, ',', '.') }}</td>
                </tr>
                <tr>
                    <td class="bolds">Jumlah yg harus di transfer</td>
                    <td>Rp </td>
                    <td>{{ number_format($sp3->Jumlah, 0, ',', '.') }}</td>
                </tr>
            </table>
            <br><br>
            <table class="payment-table-details">
                <tr>
                    <td class="bold" style="width: 25%;">Terbilang</td>
                    <td style="width: 2%;">:</td>
                    <td style="text-decoration: underline;">{{ $sp3->Terbilang }}</td>
                </tr>
                <tr>
                    <td class="bold">Rekening Bank</td>
                    <td>:</td>
                    <td>{{ $sp3->Rekening_Bank }}</td>
                </tr>
                <tr>
                    <td class="bold">Acc No.</td>
                    <td>:</td>
                    <td>{{ $sp3->Nomor_Rekening }}</td>
                </tr>
                <tr>
                    <td class="bold">A/N</td>
                    <td>:</td>
                    <td>{{ $sp3->Atas_Nama }}</td>
                </tr>
            </table>
        @else
        @endif

        <div class="signature">
            <div>
                <p class="bold" style="padding-bottom: 25%;">
                    Dibuat Oleh
                </p>
                <b>Irvan Sandoval</b>
            </div>
            <div>
                <p class="bold" style="padding-bottom: 25%;">
                    Diperiksa Oleh
                </p>
                <b>Irwandi</b>
            </div>
            <div>
                <p class="bold" style="padding-bottom: 25%;">
                    Diketahui Oleh
                </p>
                <b>Bong Tedy</b>
            </div>
        </div>
    </div>
</body>

</html>
