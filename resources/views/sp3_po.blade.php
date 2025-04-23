@php
    $image = public_path() . '/images/logo.jpg';
@endphp

<!DOCTYPE html>
<html lang="id">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title>Purchase Order</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #ffffff;
            padding: 0.5% !important;
            font-size: 13px;
        }

        .container {
            margin: 0 !important;
            padding: 0 !important;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0;
            margin-top: 5px;
        }

        .logo {
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
            margin-bottom: 5%;
            font-size: 16px;
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

        th,
        td {
            padding: 8px;
            text-align: left;
        }

        .left {
            padding: 0px;
            text-align: left;
        }

        .right {
            padding: 0px;
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
            width: 35%;
            padding-top: 0.1rem;
            padding-bottom: 0.1rem;
        }

        .shipping-fee {
            display: flex;
            justify-content: space-between;
            text-align: left;
            width: 38.9%;
            padding-bottom: 0.1rem;
        }

        .final-total {
            display: flex;
            justify-content: space-between;
            text-align: left;
            width: 32.5%;
            padding-top: 0.1rem;
            padding-bottom: 0.1rem;
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
            border: 1px solid black;
            border-spacing: 0px;
            vertical-align: top;
        }

        .left tr td {
            padding-top: 3px;
            padding-bottom: 3px;
            border-spacing: 0;
            border-collapse: collapse;
        }

        .right tr td {
            padding-top: 0px;
            padding-bottom: 0px;
            border-spacing: 0;
            border-collapse: collapse;
        }

        p {
            margin-top: 1%;
            margin-bottom: 1%;
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
            <img src="<?php echo $image; ?>" alt="Audemars Indonesia Logo" class="logo">
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
                                <strong>To:</strong>
                            </td>
                            <td>
                                <p> {{ $sp3->vendors->CompanyName }}</p>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <strong>Address:</strong>
                            </td>
                            <td>
                                @php
                                    $addressWords = explode(' ', $sp3->vendors->Address);
                                    $chunkedAddress = array_chunk($addressWords, 5);
                                @endphp
                                @foreach ($chunkedAddress as $line)
                                    <p>{{ implode(' ', $line) }}</p>
                                @endforeach
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <strong>NPWP:</strong>
                            </td>
                            <td>
                                <p>{{ $sp3->vendors->NPWP }}</p>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <strong>Telephone:</strong>
                            </td>
                            <td>
                                <p>{{ $sp3->vendors->Phone }}</p>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <strong>Subject:</strong>
                            </td>
                            <td>
                                <p>
                                <p>{{ $sp3->purchaseOrder->PO_Name }}</p>
                                </p>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <strong>PO No:</strong>
                            </td>
                            <td>
                                <p>
                                <p>{{ $sp3->purchaseOrder->PO_Code }}</p>
                                </p>
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
                            <strong>Jenis Pembayaran:</strong>
                        </td>
                        <td>
                            <p style="margin-top: 5%; margin-bottom: 5%;">{{ $sp3->purchaseOrder->Payment_Mode }}</p>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <strong>Date:</strong>
                        </td>
                        <td>
                            <p style="margin-top: 5%; margin-bottom: 5%;">
                                {{ $sp3->created_at->format('d-m-Y') }}</p>
                        </td>
                    </tr>
                </table>
            </div>
        </div>

        <!-- Table -->
        @if ($sp3->purchaseOrder->purchaseOrderItems->count() > 0)
            {{-- Check if there are any posts --}}
            <table class="inside">
                <thead>
                    <tr>
                        <th>No</th>
                        <th style="width:15%">Items</th>
                        <th>Item Description</th>
                        <th>Unit Price</th>
                        <th>Qty</th>
                        <th>Unit</th>
                        <th>Tax</th>
                        <th>Total</th>
                    </tr>
                </thead>
                @foreach ($sp3->purchaseOrder->purchaseOrderItems as $item)
                    <tbody>
                        <tr>
                            <td>1</td>
                            <td>{{ $item->Item_Name }}</td>
                            <td>{{ $item->Item_Description }}</td>
                            <td>{{ 'Rp' . number_format($item->Price, 0, ',', '.') }}</td>
                            <td>{{ $item->Quantity }}</td>
                            <td>{{ $item->Unit }}</td>
                            <td>{{ $item->Tax }}</td>
                            <td>{{ 'Rp' . number_format($item->Total, 0, ',', '.') }}</td>
                        </tr>
                    </tbody>
                @endforeach
            </table>
        @else
        @endif



        <!-- Total -->
        <div class="total">
            <div class="subtotal">
                <p>Subtotal</p>
                <p>
                    {{ 'Rp' . number_format($sp3->purchaseOrder->Sub_Total, 0, ',', '.') }}
                </p>
            </div>
            <div class="shipping-fee">
                <p>Shipping Fee</p>
                <p>
                    {{ 'Rp' . number_format($sp3->purchaseOrder->Shipping_Fee, 0, ',', '.') }}
                </p>
            </div>
            <div class="final-total">
                <p>Total</p>
                <p>
                    {{ 'Rp' . number_format($sp3->purchaseOrder->Grand_Total, 0, ',', '.') }}
                </p>
            </div>
        </div>
    </div>



    <!-- Page Break untuk Halaman Kedua -->
    <div class="page-break"></div>

    <!-- Halaman Kedua -->
    <div>
        <p><strong>Terbilang:</strong> {{ $sp3->Terbilang }}</p>
        <br>
        <p><strong><u>Vendor Bank Details</u></strong></p>
        <p><strong>Bank:</strong> Mandiri</p>
        <p><strong>Account No:</strong> 1030006931402</p>
        <p><strong>Name:</strong> MOCHAMAD IRVAN SANDO</p>
        <br>
        <p><strong><u>NPWP Information of PT Audemars Indonesia</u></strong></p>
        <p><strong>NPWP:</strong> 03.262.362.1-047.000</p>
        <p><strong>Delivery Address:</strong> Jl. Telaga Asih No.21 RT.007/RW.001 Kab. Bekasi, Cikarang Barat, Jawa
            Barat, 17530</p>
        <p><strong>Phone Number:</strong> 021-7195519</p>
        <p><strong>Payment Terms:</strong> {{ $sp3->Payment_Terms }} </p>
        <p><strong>Delivery Times: </strong> {{ $sp3->Delivery_Time }} </p>
        <p><strong>Inspection Note: </strong> {{ $sp3->Inspection_Notes }} </p>
        <p><strong>Vendor Note:</strong> Pembayaran ke vendor menggunakan Virtual Account dengan batas waktu, sehingga
            dana ditransfer ke rekening di atas dan dibayarkan melalui Virtual Account milik atas nama rekening
            tersebut.</p>
    </div>

    <!-- Signature Section -->
    <div class="signature-section">
        <div class="signature-box">
            <strong>
                <p>PT Audemars Indonesia</p>
            </strong>
            <br>
            <br>
            <b>
                <p style="margin-bottom: 1rem!important">Irvan Sandoval</p>
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
                <p style="margin-bottom: 1rem!important">Irwandi</p>
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

</body>

</html>
