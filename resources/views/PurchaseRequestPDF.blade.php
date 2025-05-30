@php
    $image = public_path() . '/images/logo.png';
@endphp
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Material Request</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 8px;
            margin: 0;
            padding: 0;
            padding-top: 2%;
        }

        .containers {
            padding-top: 5%;
            padding-left: 5%;
            padding-right: 5%;
            padding-bottom: 5%;
        }

        .headers {
            display: flex;
            border: 1px solid #000;
        }

        .logo-section {
            width: 30%;
            border-right: 1px solid #000;
            text-align: center;
        }

        .title-section {
            font-size: 12px;
            width: 60%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
        }

        .doc-info-section {
            width: 34%;
            font-size: 9px;
            border-left: 1px solid #000;
        }

        .doc-info-row {
            display: flex;
            border-bottom: 1px solid #000;
        }

        .doc-info-row:last-child {
            border-bottom: none;
        }

        .doc-info-label {
            width: 50%;
            padding: 5px;
            border-right: 1px solid #000;
        }

        .doc-info-value {
            width: 50%;
            padding: 5px;
        }

        .content-table {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 20px 80px;
        }

        .content {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding-left: 15px;
            padding-right: 15px;
            padding-top: 5px;
            padding-bottom: 5px;
        }

        .content-info {
            display: flex;
            padding: 0 !important;
            margin: 0 !important;
        }

        .box {
            border: 1px solid black;
        }

        /* TABLE */
        .tg {
            border-collapse: collapse;
            border-spacing: 0;
        }

        .tg td {
            border-color: black;
            border-style: solid;
            border-width: 1px;
            font-family: Arial, sans-serif;
            font-size: 9px;
            overflow: hidden;
            word-break: normal;
        }

        .tg th {
            border-color: black;
            border-style: solid;
            border-width: 1px;
            font-family: Arial, sans-serif;
            font-size: 9px;
            font-weight: bold;
            overflow: hidden;
            word-break: normal;
        }

        .tg .tg-0pky {
            border-color: inherit;
            text-align: center;
            white-space: nowrap;
            vertical-align: center;
        }

        .tg .tg-0lax {
            text-align: center;
            white-space: nowrap;
            vertical-align: center;
        }

        .signature-section {
            display: flex;
            margin-top: 10px;
        }

        .signature-box {
            width: 25%;
            border: 1px solid #000;
            height: 70px;
            text-align: center;
            padding-top: 0px;
        }

        .page-break {
            page-break-before: always;
            /* Memastikan konten setelah ini ada di halaman kedua */
        }
    </style>
</head>

<body>
    <div class="containers">

        <div class="headers">
            <div class="logo-section">
                <center>
                    <img src="<?php echo $image; ?>" alt="Audemars Indonesia Logo" class="logo"
                        style="width: 150px; height: 42px; border: none;">
                </center>
            </div>
            <div class="title-section">
                MATERIAL REQUEST (MR)
            </div>
            <div class="doc-info-section">
                <div class="doc-info-row">
                    <div class="doc-info-label" style="padding: 0;">Nomor Dokumen</div>
                    <div class="doc-info-value" style="padding: 0;">AMI-F-PROC-P-01/01</div>
                </div>
                <div class="doc-info-row">
                    <div class="doc-info-label" style="padding: 0;">Revisi</div>
                    <div class="doc-info-value" style="padding: 0;">00</div>
                </div>
                <div class="doc-info-row">
                    <div class="doc-info-label" style="padding: 0;">Tanggal Terbit</div>
                    <div class="doc-info-value" style="padding: 0;">
                        {{ \Carbon\Carbon::now()->locale('id')->translatedFormat('j F Y') }}
                    </div>
                </div>
                <div class="doc-info-row">
                    <div class="doc-info-label" style="padding: 0;">Halaman</div>
                    <div class="doc-info-value" style="padding: 0;">1/1</div>
                </div>
            </div>
        </div>

        @if ($data)
            <div class="content">
                <div class="content-left">
                    <table>
                        <tr>
                            <td>
                                <p style="margin: 0px 0px;"><b>Mr Number </b></p>
                            </td>
                            <td>
                                <p style="margin: 0px 0px;">: {{ $data->PR_Code }}</p>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <p style="margin: 0px 0px;"><b>Date </b></p>
                            </td>
                            <td>
                                <p style="margin: 0px 0px;"> :
                                    {{ \Carbon\Carbon::now()->locale('id')->translatedFormat('j F Y') }}</p>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <p style="margin: 0px 0px;"><b>Location</b></p>
                            </td>
                            <td>
                                <p style="margin: 0px 0px;">: Jakarta</p>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <p style="margin: 0px 0px;"><b>Page No</b></p>
                            </td>
                            <td>
                                <p style="margin: 0px 0px;">: 1/1</p>
                            </td>
                        </tr>
                    </table>
                    <div class="content-info">
                    </div>
                    <div class="content-info">
                    </div>
                </div>
                <div class="content-right"">
                    <table>
                        <tr>
                            <td>
                                <p style="margin: 0px 0px;"><b>Location</b></p>
                            </td>
                            <td>
                                <p style="margin: 0px 0px;">: Jakarta</p>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <p style="margin: 0px 0px;"><b>Page No</b></p>
                            </td>
                            <td>
                                <p style="margin: 0px 0px;">: 1/1</p>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <p style="margin: 0px 0px;"><b>Requested By</b></p>
                            </td>
                            <td>
                                <p style="margin: 0px 0px;">: {{ $data->RequestedBy }}</p>
                            </td>
                        </tr>
                    </table>
                    <br>
                </div>
            </div>
        @else
        @endif

        <div class="box">
            <center>
                @if ($data->purchaseRequestItems->isNotEmpty())
                    <table class="tg">
                        <thead>
                            <tr>
                                <th class="tg-0pky" rowspan="2" style="width: 3%">NO</th>
                                <th class="tg-0pky" rowspan="2" style="width: 12%">PART NUMBER/SIZE</th>
                                <th class="tg-0pky" rowspan="2" style="width: 38%" style="">ITEMS DESCRIPTION
                                </th>
                                <th class="tg-0pky" rowspan="2" style="width: 3%">QTY</th>
                                <th class="tg-0pky" rowspan="2" style="width: 3%">UNIT</th>
                                <th class="tg-0pky" rowspan="2" style="width: 3%">ON <br> HAND</th>
                                <th class="tg-0pky" colspan="3" style="width: 20%">LAST RECEIVED</th>
                                <th class="tg-0lax" rowspan="2" style="width: 25%;">REMARKS</th>
                            </tr>
                            <tr>
                                <th class="tg-0pky">DATE</th>
                                <th class="tg-0pky">QTY</th>
                                <th class="tg-0lax">UNIT</th>
                            </tr>
                        </thead>
                        <tbody style="text-align: center;">
                            @foreach ($data->purchaseRequestItems as $item)
                                <tr>
                                    <td class="tg-0pky">{{ $loop->iteration }}</td>
                                    <td class="tg-0pky"></td>
                                    <td class="tg-0pky" style="text-align: left;">{{ $item->Item_Name }}</td>
                                    <td class="tg-0pky">{{ $item->Quantity }}</td>
                                    <td class="tg-0pky">{{ $item->Unit }}</td>
                                    <td class="tg-0pky"></td>
                                    <td class="tg-0pky"></td>
                                    <td class="tg-0pky"></td>
                                    <td class="tg-0lax"></td>
                                    {{-- @if ($loop->first)
                                    <td class="tg-0lax" rowspan="{{ $data->purchaseRequestItems->count() }}">
                                        {{ $data->Item_Description }}
                                    </td>
                                @endif --}}
                                    <td class="tg-0lax">
                                        {{ $item->Item_Description }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else
                @endif
            </center>

            <div class="signature-section">
                <div class="signature-box">
                    Prepare By
                    <p style="padding-top: 22%;">Irvan Sandoval</p>
                </div>
                <div class="signature-box">
                    Check By
                </div>
                <div class="signature-box">
                    Aprroved By
                    <p style="padding-top: 22%;">Irwandi</p>
                </div>
                <div class="signature-box">
                    Receive By
                </div>
            </div>
        </div>

    </div>
</body>

</html>
