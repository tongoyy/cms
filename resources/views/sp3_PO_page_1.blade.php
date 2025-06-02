@php
    $image = public_path() . '/images/logo.png';
@endphp

<!DOCTYPE html>
<html lang="id">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SPPP_PO</title>

    <style>
        body {
            font-family: Helvetica, sans-serif;
            background-color: #ffffff;
            font-size: 11px;
        }

        .container {
            padding-top: 5%;
            padding-bottom: 5%;
            padding-left: 3%;
            padding-right: 3%;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .logos {
            width: 15%;
        }

        .document-info {
            text-align: right;
            font-size: 9px;
        }

        .title {
            text-align: center;
            font-weight: bold;
            margin-top: 0;
            margin-bottom: 3%;
            font-size: 12px;
        }

        .info {
            display: flex;
            justify-content: space-between;
            padding-bottom: 2%;
        }

        .inside {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        .left {
            text-align: left;
            vertical-align: top;
        }

        .right {
            text-align: left;
        }

        th {
            -webkit-print-color-adjust: exact;
            color-adjust: exact;
            background-color: rgb(54, 54, 54) !important;
            color: white;
        }

        @media print {
            th {
                background-color: rgb(56, 56, 56);
                color: white;
            }
        }

        .total {
            display: flexbox;
            justify-items: flex-end;
            text-align: right;
            margin-top: 20px;
        }

        .subtotal {
            display: flex;
            justify-content: space-between;
            text-align: left;
            width: 38%;
            padding-top: 0.1rem;
            padding-bottom: 0.1rem;
        }

        .final-total {
            display: flex;
            justify-content: space-between;
            text-align: left;
            width: 35.5%;
            padding-top: 0.1rem;
            padding-bottom: 0.1rem;
        }

        .row {
            display: flex;
            margin-bottom: 6px;
        }

        .label {
            font-weight: normal;
            width: 150px;
            padding-right: 10px;
            vertical-align: top;
        }

        .value {
            flex: 1;
        }

        .section-header {
            font-weight: bold;
            margin-top: 15px;
            margin-bottom: 8px;
            text-decoration: underline;
        }

        .italic-text {
            font-style: italic;
        }

        .bank-info {
            text-align: left;
            margin-top: 30px;
            font-size: 0.8rem;
        }

        .approval {
            display: inline-block;
            justify-content: space-between;
            margin-top: 50px;
            text-align: center;
            width: 100%;
        }

        .approval p {
            margin-bottom: 5px;
        }

        .approval small {
            font-size: 14px;
            color: gray;
        }

        .approval-title {
            display: flex;
            justify-content: space-around;
            padding-bottom: 10%;
        }

        .approval-list {
            display: flex;
            justify-content: space-around;
        }

        .inside tr td {
            font-size: 14px;
            border: 1px solid black;
            border-spacing: 0px;
            vertical-align: top;
        }

        .left tr td {
            padding-top: 0px;
            padding-bottom: 0px;
            border-spacing: 0;
            border-collapse: collapse;
        }

        .right tr td {
            padding-top: 0px;
            padding-bottom: 0px;
            border-spacing: 0;
            border-collapse: collapse;
        }

        strong {
            text-wrap: nowrap;
        }

        .page-break {
            page-break-before: always;
            /* Memastikan konten setelah ini ada di halaman kedua */
        }

        .signature-section {
            text-align: center;
            margin-top: 50px;
        }

        .signature-box {
            display: inline-block;
            width: 30%;
            text-align: center;
            vertical-align: top;
        }

        .signature-box p {
            margin-top: 40px;
            /* Jarak untuk tanda tangan */
        }
    </style>
</head>

<body>

    <div class="container">
        <!-- Header -->
        <div class="header">
            <img src="<?php echo $image; ?>" alt="Audemars Indonesia Logo" class="logos">
            <div class="document-info">
                <table>
                    <tr>
                        <td class="doc-info">
                            Nomor Dokumen:
                        </td>
                        <td class="doc-info">
                            AMI-F-PROC-P-01/01
                        </td>
                    </tr>
                    <tr>
                        <td class="doc-info">
                            Revisi:
                        </td>
                        <td class="doc-info">
                            02
                        </td>
                    </tr>
                    <tr>
                        <td class="doc-info">
                            Tanggal Terbit:
                        </td>
                        <td class="doc-info">
                            {{ \Carbon\Carbon::now()->locale('id')->translatedFormat('j F Y') }}
                        </td>
                    </tr>
                </table>
            </div>
        </div>

        <h2 class="title">PURCHASE ORDER</h2>

        <!-- Detail Information -->
        <div class="info">
            <div class="left">
                @if ($sp3->vendors)
                    <table class="left-tables" border="0" cellspacing="0" cellpadding="0">
                        <tr>
                            <td>
                                <p style="margin:3px; padding:3px;"><strong>To:</strong></p>
                            </td>
                            <td>
                                <p style="margin:3px; padding:3px;">{{ $sp3->vendors->CompanyName }}</p>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <p style="margin:3px; padding:3px;"><strong>Address:</strong></p>
                            </td>
                            <td>
                                <p style="margin:3px; padding:3px;">{{ $sp3->vendors->Address }}</p>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <p style="margin:3px; padding:3px;"><strong>NPWP:</strong></p>
                            </td>
                            <td>
                                <p style="margin:3px; padding:3px;">{{ $sp3->vendors->NPWP }}</p>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <p style="margin:3px; padding:3px;"><strong>Subject:</strong></p>
                            </td>
                            <td>
                                <p style="margin:3px; padding:3px;">{{ $sp3->purchaseOrder->PO_Name }}</p>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <p style="margin:3px; padding:3px;"><strong>PO No:</strong></p>
                            </td>
                            <td>
                                <p style="margin:3px; padding:3px;">{{ $sp3->purchaseOrder->PO_Code }}</p>
                            </td>
                        </tr>
                    </table>
                @else
                @endif
            </div>
            <div class="right">
                <table class="right-tables" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                        <td>
                            <p style="margin:3px; padding:3px;"><strong>Jenis Pembayaran:</strong></p>
                        </td>
                        <td>
                            <p style="margin:3px; padding:3px;">{{ $sp3->Payment_Mode }}</p>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <p style="margin:3px; padding:3px;"><strong>Date:</strong></p>
                        </td>
                        <td>
                            <p style="margin:3px; padding:3px;">{{ $sp3->created_at->format('d-m-Y') }}</p>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <p style="margin:3px; padding:3px;"><strong>Kategori:</strong></p>
                        </td>
                        <td>
                            <p style="margin:3px; padding:3px;">{{ $sp3->Department }}</p>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <p style="margin:3px; padding:3px;"><strong>Telephone:</strong></p>
                        </td>
                        <td>
                            <p style="margin:3px; padding:3px;">{{ $sp3->vendors->Phone }}</p>
                        </td>
                    </tr>
                </table>
            </div>
        </div>

        <!-- Table -->
        @if ($sp3->purchaseOrderItems->isNotEmpty())
            {{-- Check if there are any posts --}}
            <table class="inside">
                <thead>
                    <tr>
                        <th style="font-size:14px; padding:2px; font-weight:100; width: 5%">NO</th>
                        <th style="font-size:14px; padding:2px; font-weight:100; width:20%">ITEMS</th>
                        <th style="font-size:14px; padding:2px; font-weight:100; width:30%">DESCRIPTION</th>
                        <th style="font-size:14px; padding:2px; font-weight:100; width:20%">UNIT PRICE</th>
                        <th style="font-size:14px; padding:2px; font-weight:100; width:5%">QTY</th>
                        <th style="font-size:14px; padding:2px; font-weight:100; width:10%">UNIT</th>
                        <th style="font-size:14px; padding:2px; font-weight:100; width:20%">TOTAL</th>
                    </tr>
                </thead>
                @foreach ($sp3->purchaseOrderItems as $poItems)
                    <tbody>
                        <tr>
                            <td style="padding:2px;">{{ $loop->iteration }}</td>
                            <td style="padding:2px;">{{ $poItems->Item_Name }}</td>
                            <td style="padding:2px;">{{ $poItems->Item_Description }}</td>
                            <td style="padding:2px;">{{ $poItems->Price }}</td>
                            <td style="padding:2px;">{{ $poItems->Quantity }}</td>
                            <td style="padding:2px;">{{ $poItems->Unit }}</td>
                            <td style="padding:2px;">{{ $poItems->Total }}</td>
                        </tr>
                    </tbody>
                @endforeach
            </table>
        @else
        @endif

        <!-- Total -->
        <div class="total">
            <div class="subtotal">
                <p style="padding: 1%; margin: 1%;">Subtotal</p>
                <p style="padding: 1%; margin: 1%;">
                    {{ 'Rp' . number_format($sp3->PurchaseOrder->Sub_Total, 0, ',', '.') }}
                </p>
            </div>
            <div class="final-total">
                <p style="padding: 1%; margin: 1%;">Total</p>
                <p style="padding: 1%; margin: 1%;">
                    {{ 'Rp' . number_format($sp3->PurchaseOrder->Grand_Total, 0, ',', '.') }}
                </p>
            </div>
        </div>

        <div class="row" style="margin-top: 40px">
            <div class="label"><strong>Terbilang:</strong></div>
            <div class="value">TUJUH JUTA TUJUH RATUS DELAPAN PULUH RIBU RUPIAH</div>
        </div>

        <div class="section-header">Vendor Bank Details</div>

        <div class="row">
            <div class="label">Bank:</div>
            <div class="value">Mandiri</div>
        </div>

        <div class="row">
            <div class="label">Account No:</div>
            <div class="value">1260006101603</div>
        </div>

        <div class="row">
            <div class="label">Name:</div>
            <div class="value">KUI LIAN</div>
        </div>

        <div class="section-header">NPWP Information of PT Audemars Indonesia</div>

        <div class="row">
            <div class="label">NPWP:</div>
            <div class="value">03.262.362.1-047.000</div>
        </div>

        <div class="row">
            <div class="label">Delivery Address:</div>
            <div class="value">Jl. Telaga Asih No.21 RT.007/RW.001 Kab. Bekasi, Cikarang Barat, Jawa Barat, 17530</div>
        </div>

        <div class="row">
            <div class="label">Phone Number:</div>
            <div class="value">021-7195519</div>
        </div>

        <div class="row">
            <div class="label">Payment Terms:</div>
            <div class="value">Barang diproses setelah dana masuk</div>
        </div>

        <div class="row">
            <div class="label">Delivery Time:</div>
            <div class="value"></div>
        </div>

        <div class="row">
            <div class="label">Delivery Point:</div>
            <div class="value"></div>
        </div>

        <div class="row">
            <div class="label">Inspection Terms:</div>
            <div class="value italic-text" style="line-height: 2;">
                Every supplied goods meet the stated goods specifications upon delivery, the goods will <br>
                be inspected. Those goods that did not meet requirement or damage will be rejected <br>
                and returned to the supplier for replacement.
            </div>
        </div>

        <!-- Signature Section -->
        <div class="signature-section" style="margin-top: 10px;">
            <div class="signature-box">
                <strong>
                    <p>PT Audemars Indonesia</p>
                </strong>
                <br>
                <br>
                <b>
                    <p style="margin-bottom: 0!important">Irvan Sandoval</p>
                </b>
                <p style="margin: 0!important">Purchasing</p>
            </div>
            <div class="signature-box">
                <strong>
                    <p>PT Audemars Indonesia</p>
                </strong>
                <br>
                <br>
                <b>
                    <p style="margin-bottom: 0!important">Irwandi</p>
                </b>
                <p style="margin: 0!important">Direktur</p>
            </div>
            <div class="signature-box">
                <b>
                    <p>{{ $sp3->vendors->CompanyName }}</p>
                </b>
                <br>
                <br>
                <p>________________________</p>
            </div>
        </div>

        <div class="page-break"></div>

</body>

</html>
