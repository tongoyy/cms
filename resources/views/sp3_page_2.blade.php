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
                        <td>29 Juli 2024</td>
                    </tr>
                </table>
            </div>
        </div>

        <table class="info-table" style="padding: 10px 0;">
            <tbody>
                <tr>
                    <td></td>
                </tr>
                <tr>
                    <td class="bold" width="100">SPPP No</td>
                    <td>: 00092/AMI-SP3/11/2023</td>
                </tr>
                <tr>
                    <td class="bold">Date</td>
                    <td>: 15 Nov 2023</td>
                </tr>
                <tr>
                    <td class="bold">To</td>
                    <td>:</td>
                    <td class="bold">KP</td>
                    <td>:</td>
                </tr>
                <tr>
                    <td class="bold">Fax</td>
                    <td>:</td>
                    <td class="bold" width="100">Pemakaian</td>
                    <td>: Zona 4</td>
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

        <table class="payment-tyoe">
            <tr>
                <td class="bold"><strong>Jenis Pembayaran</strong></td>
                <td>:</td>
            </tr>
        </table>
        <br>
        <p>Terlampir kami kirim dokumen pendukung pembayaran antara lain :</p>

        <div style="display: flex;">
            <table class="payment-info-table" style="white-space: nowrap;">
                <tr>
                    <td class="bold">1. Nama Supplier</td>
                    <td style="padding-right: 5rem;">: &nbsp; MOCHAMAD IRVAN SANDOVAL</td>
                </tr>
                <tr>
                    <td class="bold">2. No. Invoice</td>
                    <td>: &nbsp;</td>
                </tr>
                <tr>
                    <td class="bold">3. No. Kwitansi</td>
                    <td>: &nbsp;</td>
                </tr>
                <tr>
                    <td class="bold">4. No. Purchase Order</td>
                    <td>: &nbsp; #PR-00091-2023-MANUFACTURE</td>
                </tr>
                <tr>
                    <td class="bold">5. No. Delivery Order</td>
                    <td>: &nbsp;</td>
                </tr>
                <tr>
                    <td class="bold">6. No. Faktur Pajak</td>
                    <td>: &nbsp;</td>
                </tr>
                <tr>
                    <td class="bold">7. Masa SSP</td>
                    <td>: &nbsp;</td>
                </tr>
            </table>

            <table class="payment-info-table" style="white-space: nowrap;">
                <tr>
                    <td class="bold">Tgl</td>
                    <td>:</td>
                </tr>
                <tr>
                    <td class="bold">Tgl</td>
                    <td>:</td>
                </tr>
                <tr>
                    <td class="bold">Tgl</td>
                    <td>:</td>
                </tr>
                <tr>
                    <td class="bold">Tgl</td>
                    <td>: 15-11-2023</td>
                </tr>
                <tr>
                    <td class="bold">Tgl</td>
                    <td>:</td>
                </tr>
                <tr>
                    <td class="bold">Tgl</td>
                    <td>:</td>
                </tr>
                <tr>
                    <td class="bold">Tgl</td>
                    <td>:</td>
                </tr>
            </table>
        </div>

        <table style="padding: 0px 25px 0px 0px;">
            <tr>
                <td class="bold" style="white-space: nowrap; padding: 0px 25px 0px 0px;">Untuk Pembayaran</td>
                <td> : &nbsp; CASH ADVANCE : Renovasi mess Cibitung, termasuk cat, perbaikan
                    furniture,
                    peremajaan
                    tools/perkakas</td>
            </tr>
        </table>

        <table class="payment-table-details">
            <tr>
                <td class="bolds" style="width: 30%;">Amount</td>
                <td style="width: 12%;">Rp </td>
                <td style="width: 50%;">2.000.000</td>
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
                <td>2.000.000</td>
            </tr>
            <tr>
                <td class="bolds">Jumlah yg harus di transfer</td>
                <td>Rp </td>
                <td>2.000.000</td>
            </tr>
        </table>
        <br><br>
        <table class="payment-table-details">
            <tr>
                <td class="bold" style="width: 25%;">Terbilang</td>
                <td style="width: 2%;">:</td>
                <td style="text-decoration: underline;">DUA JUTA RUPIAH</td>
            </tr>
            <tr>
                <td class="bold">Rekening Bank</td>
                <td>:</td>
                <td>MANDIRI</td>
            </tr>
            <tr>
                <td class="bold">Acc No.</td>
                <td>:</td>
                <td>1030006931402</td>
            </tr>
            <tr>
                <td class="bold">A/N</td>
                <td>:</td>
                <td>MOCHAMAD IRVAN SANDOVAL</td>
            </tr>
        </table>

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
