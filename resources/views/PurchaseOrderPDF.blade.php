@php
    $image = public_path() . '/images/logo.jpg';
@endphp

<!DOCTYPE html>
<html lang="id">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title>Purchase Request</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #ffffff;
            padding: 5% !important;
            font-size: 12px;
        }

        .container {
            margin: 0;
            padding: 0;
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
            margin-bottom: 0;
            font-size:14px;
        }

        .info {
            display: flex;
            justify-content: space-between;
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
                @if ($data->vendors)
                    <table class="left-tables" border="0" cellspacing="0" cellpadding="0">
                        <tr>
                            <td>
                                <strong>To:</strong>
                            </td>
                            <td>
                                <p> {{ $data->vendors->CompanyName }}</p>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <strong>Address:</strong>
                            </td>
                            <td>
                                <p>{{ $data->vendors->Address }}</p>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <strong>NPWP:</strong>
                            </td>
                            <td>
                                <p>{{ $data->vendors->NPWP }}</p>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <strong>Telephone:</strong>
                            </td>
                            <td>
                                <p>{{ $data->vendors->Phone }}</p>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <strong>Subject:</strong>
                            </td>
                            <td>
                                <p>
                                    <p>{{ $data->PO_Name }}</p>
                                </p>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <strong>PO No:</strong>
                            </td>
                            <td>
                                <p>
                                    <p>{{ $data->PO_Code }}</p>
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
                            <p style="margin-top: 5%; margin-bottom: 5%;">{{ $data->Payment_Mode }}</p>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <strong>Date:</strong>
                        </td>
                        <td>
                            <p style="margin-top: 5%; margin-bottom: 5%;">
                                {{ $data->created_at->format('d-m-Y') }}</p>
                        </td>
                    </tr>
                </table>
            </div>
        </div>

        <!-- Table -->
        @if ($data->purchaseOrderItems->isNotEmpty())
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
                @foreach ($data->purchaseOrderItems as $poItems)
                    <tbody>
                        <tr>
                            <td>1</td>
                            <td>{{ $poItems->Item_Name }}</td>
                            <td>{{ $poItems->Item_Description }}</td>
                            <td>{{ $poItems->Price }}</td>
                            <td>{{ $poItems->Quantity }}</td>
                            <td>{{ $poItems->Unit }}</td>
                            <td>{{ $poItems->Tax }}</td>
                            <td>{{ $poItems->Total }}</td>
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
                    {{ 'Rp' . number_format($data->Sub_Total, 0, ',', '.') }}
                </p>
            </div>
            <div class="shipping-fee">
                <p>Shipping Fee</p>
                <p> 
                    {{ 'Rp' . number_format($data->Shipping_Fee, 0, ',', '.') }}
                </p>
            </div>
            <div class="final-total">
                <p>Total</p>
                <p>
                    {{ 'Rp' . number_format($data->Total, 0, ',', '.') }}
                </p>
            </div>
        </div>

    </div>

</body>

</html>
