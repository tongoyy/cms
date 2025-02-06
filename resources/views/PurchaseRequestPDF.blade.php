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
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0;
            margin-top: 1%;
        }

        .logo {
            max-width: 15%;
            max-height: 10%;
        }

        .document-info {
            text-align: right;
            font-size: 9px;
            padding-right: 0;
        }

        .title {
            text-align: center;
            font-weight: bold;
            margin-top: 0;
            margin-bottom: 0;
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
            padding-top: 1%;
            padding-bottom: 1%;
        }

        .final-total {
            display: flex;
            justify-content: space-between;
            text-align: left;
            width: 35%;
            padding-top: 1%;
            padding-bottom: 1%;
        }

        .bank-info {
            text-align: left;
            margin-top: 30px;
            font-size: 0.7rem;
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
                            {{ now()->format('D-M-Y') }}
                        </td>
                    </tr>
                </table>
            </div>
        </div>

        <h2 class="title">PURCHASE REQUEST</h2>

        <!-- Detail Information -->
        <div class="info">
            <div class="left">
                @if ($data)
                    <table class="left-tables" border="0" cellspacing="0" cellpadding="0">
                        <tr>
                            <td>
                                <strong>Requester:</strong>
                            </td>
                            <td>
                                <p> Irvan Sandoval</p>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <strong>Project:</strong>
                            </td>
                            <td>
                                <p>{{ $data->Project }}</p>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <strong>PR Number:</strong>
                            </td>
                            <td>
                                <p>{{ $data->PR_Code }}</p>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <strong>Type:</strong>
                            </td>
                            <td>
                                <p></p>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <strong>RAB Ref:</strong>
                            </td>
                            <td>
                                <p>Project</p>
                            </td>
                        </tr>
                        <tr>
                            <td style="vertical-align: top; padding-top: 1%;">
                                <strong>Description:</strong>
                            </td>
                            <td>
                                <p>
                                    Peserta: 1. Aziz Fahrurrozi, 2. Andis Faza Fauzana, 3. Sri Rahmayani<br>
                                    Tanggal: 1 s/d 2 Maret 2023<br>
                                    Tujuan: Pengecekan sumber listrik FAST untuk Lapangan JTB-89
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
                            <strong>Purchase Type:</strong>
                        </td>
                        <td>
                            <p style="margin-top: 5%; margin-bottom: 5%;">{{ $data->PurchaseType }}</p>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <strong>Department:</strong>
                        </td>
                        <td>
                            <p style="margin-top: 5%; margin-bottom: 5%;">{{ $data->Department }}</p>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <strong>Date Created:</strong>
                        </td>
                        <td>
                            <p style="margin-top: 5%; margin-bottom: 5%;">
                                {{ $data->created_at->format('D-M-Y') }}</p>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <strong>Due Date:</strong>
                        </td>
                        <td>
                            <p style="margin-top: 5%; margin-bottom: 5%;">{{ $data->DueDate }}</p>
                        </td>
                    </tr>
                </table>
            </div>
        </div>

        <!-- Table -->
        @if ($data->items->isNotEmpty())
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
                @foreach ($data->items as $item)
                    <tbody>
                        <tr>
                            <td>1</td>
                            <td>{{ $item->Item_Name }}</td>
                            <td>{{ $item->Item_Description }}</td>
                            <td>{{ $item->Quantity }}</td>
                            <td>{{ $item->Price }}</td>
                            <td>{{ $item->Unit }}</td>
                            <td>{{ $item->Tax }}</td>
                            <td>{{ $item->Total }}</td>
                        </tr>
                    </tbody>
                @endforeach
            </table>
        @else
        @endif

        <!-- Total -->
        <div class="total">
            <div class="subtotal">
                <strong>Subtotal:</strong>
                Rp2.400.000
            </div>
            <div class="final-total">
                <strong>Total:</strong>
                Rp2.400.000
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
                <p>Irvan Sandoval<br><small>Verifikator</small></p>
                <p>Faisal Akbar<br><small>Operation Manager</small></p>
                <p>Irwandi<br><small>Direktur</small></p>
                <p>Charles Teo<br></p>
            </div>
        </div>

    </div>

</body>

</html>
