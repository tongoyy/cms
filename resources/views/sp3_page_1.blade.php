@php
    $image = public_path() . '/images/logo.jpg';
@endphp

<!DOCTYPE html>
<html lang="id">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title>Purchase Request</title>

    <style>
        .container {
            font-family: Arial, sans-serif;
            background-color: #ffffff;
            padding: 5% !important;
            font-size: 12px;
        }

        .container {
            margin: 0;
            padding: 0;
        }

        .headers {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0;
            margin-top: 5px;
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
            margin-bottom: 0;
            font-size: 14px;
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

        .final-total {
            display: flex;
            justify-content: space-between;
            text-align: left;
            width: 32%;
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
    </style>
</head>

<body>

    <div class="container">
        <!-- Header -->
        <div class="headers">
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

        <h2 class="title">PURCHASE REQUEST</h2>

        <!-- Detail Information -->
        <div class="info">
            <div class="left">
                @if ($sp3)
                    <table class="left-tables" border="0" cellspacing="0" cellpadding="0">
                        <tr>
                            <td>
                                <strong>Project:</strong>
                            </td>
                            <td>
                                <p>{{ $sp3->purchaseRequest->Project }}</p>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <strong>PR Number:</strong>
                            </td>
                            <td>
                                <p>{{ $sp3->purchaseRequest->PR_Code }}</p>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <strong>Description:</strong>
                            </td>
                            <td>
                                <p>{{ $sp3->purchaseRequest->Description }}</p>
                            </td>
                        </tr>
                    </table>
            </div>
            <div class="right">
                <table class="right-tables" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                        <td>
                            <p style="margin-top: 7px; font-weight:bold">Purchase Type:</p>
                        </td>
                        <td>
                            <p style="margin-top: 7px;">{{ $sp3->purchaseRequest->PurchaseType }}</p>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <p style="margin-top: 11px; margin-bottom:3px; font-weight:bold">Department:</p>
                        </td>
                        <td>
                            <p style="margin-top: 11px; margin-bottom:3px">{{ $sp3->purchaseRequest->Department }}</p>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <p style="margin-top: 10px; font-weight:bold">Date Created:</p>
                        </td>
                        <td>
                            <p style="margin-top: 10px;">
                                {{ $sp3->created_at->format('d-m-Y') }}</p>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <p style="margin-top: 14px; font-weight:bold">Due Date:</p>
                        </td>
                        <td>
                            <p style="margin-top: 14px;">
                                {{ \Carbon\Carbon::parse($sp3->DueDate)->format('d-m-Y') }}</p>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    @else
        @endif

        <!-- Table -->
        @if ($sp3->purchaseRequest->purchaseRequestItems->count() > 0)
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
                @foreach ($sp3->purchaseRequest->purchaseRequestItems as $item)
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
                {{ 'Rp' . number_format($sp3->purchaseRequest->SubTotal, 0, ',', '.') }}
            </div>
            <div class="final-total">
                <p>Total</p>
                {{ 'Rp' . number_format($sp3->purchaseRequest->GrandTotal, 0, ',', '.') }}
            </div>
        </div>

        <!-- Bank Information -->
        <div class="bank-info">
            <p>Dana dapat ditransfer ke nomor rekening:</p>
            <p><strong>Mochamad Irvan Sandoval 1030006931402</strong></p>
        </div>

        <!-- Approval Section -->
        <div class="approval">
            <div class="approval-title">
                <p><strong>Diketahui oleh</strong></p>
                <p><strong>Disetujui oleh</strong></p>
            </div>

            <div class="approval-list">
                <p><strong>Irvan Sandoval</strong><br><small>Verifikator</small></p>
                <p><strong>Faisal Akbar</strong><br><small>Operation Manager</small></p>
                <p><strong>Irwandi</strong><br><small>Direktur</small></p>
                <p><strong>Charles Teo</strong><br></p>
            </div>
        </div>

        <div class="page-break">

        </div>

    </div>

</body>

</html>
