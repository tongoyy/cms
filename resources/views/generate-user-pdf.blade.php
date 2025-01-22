<html>

<head>
    <title>
        Purchase Request
    </title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet" />
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            padding: 20px;
        }

        .container {
            max-width: 800px;
            margin: 0 auto;
            border: 1px solid #000;
            padding: 20px;
        }

        .header {
            top: 15%;
            text-align: center;
            margin-bottom: 20px;
        }

        .kop-surat {
            display: inline-block;
            justify-content: space-around;
        }

        .header img {
            max-width: 150px;
        }

        .header h1 {
            font-size: 24px;
            margin: 10px 0;
        }

        .details,
        .table-container,
        .footer {
            margin-bottom: 20px;
        }

        .details table,
        .footer table {
            width: 100%;
            border-collapse: collapse;
        }

        .details td,
        .footer td {
            padding: 5px;
        }

        .details td:first-child {
            width: 150px;
            font-weight: bold;
        }

        .table-container table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        .table-container th,
        .table-container td {
            border: 1px solid #000;
            padding: 8px;
            text-align: left;
        }

        .table-container th {
            background-color: #f2f2f2;
        }

        .footer {
            text-align: center;
        }

        .footer .signatures {
            display: flex;
            justify-content: space-between;
            margin-top: 40px;
        }

        .footer .signatures div {
            text-align: center;
            width: 25%;
        }

        .footer .signatures div p {
            margin: 5px 0;
        }
    </style>
</head>

<body>
    <div class="kop_surat">
        <img alt="Audemars Indonesia Logo" height="80" src="{{ $images }}" width="160"
            style="padding-top:-10%;" />
    </div>
    <div class="header">
        <h1 style="font-size: 15px;">
            PURCHASE REQUEST
        </h1>
    </div>
    <div class="details">
        <table>
            <tr>
                <td>
                    Requester:
                </td>
                <td>
                    Irvan Sandoval
                </td>
                <td>
                    Purchase Type:
                </td>
                <td>
                    Pembiayaan
                </td>
            </tr>
            <tr>
                <td>
                    Project:
                </td>
                <td>
                    Zona 7
                </td>
                <td>
                    Department:
                </td>
                <td>
                    Operation
                </td>
            </tr>
            <tr>
                <td>
                    PR Number:
                </td>
                <td>
                    #PR-00001-2023-PROJECT
                </td>
                <td>
                    Date Created:
                </td>
                <td>
                    24-02-2023
                </td>
            </tr>
            <tr>
                <td>
                    Type:
                </td>
                <td>
                    CAPEX
                </td>
                <td>
                    Due Date:
                </td>
                <td>
                    28-02-2023
                </td>
            </tr>
            <tr>
                <td>
                    RAB Ref:
                </td>
                <td>
                    Project
                </td>
                <td>
                </td>
                <td>
                </td>
            </tr>
            <tr>
                <td>
                    Description:
                </td>
                <td colspan="3">
                    Peserta: 1. Aziz Fahrurrozi, 2. Andis Faza Fauzana, 3. Sri Rahmayani
                    <br />
                    Tanggal: 1 s/d 2 Maret 2023
                    <br />
                    Tujuan: Pengecekan sumber listrik FAST untuk Lapangan JTB-89
                </td>
            </tr>
        </table>
    </div>
    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th>
                        No
                    </th>
                    <th>
                        Item Description
                    </th>
                    <th>
                        Unit price
                    </th>
                    <th>
                        Qty
                    </th>
                    <th>
                        Unit
                    </th>
                    <th>
                        Total
                    </th>
                    <th>
                        Remarks
                    </th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>
                        1
                    </td>
                    <td>
                        Transportasi / Mobil Operasional
                        <br />
                        BBM JKT to CRB (PP)
                    </td>
                    <td>
                        Rp800.000
                    </td>
                    <td>
                        1.00
                    </td>
                    <td>
                        Rp800.000
                    </td>
                    <td>
                        Rp800.000
                    </td>
                    <td>
                    </td>
                </tr>
                <tr>
                    <td>
                        2
                    </td>
                    <td>
                        Transportasi / Mobil Operasional
                        <br />
                        Tol JKT to CRB (PP)
                    </td>
                    <td>
                        Rp300.000
                    </td>
                    <td>
                        1.00
                    </td>
                    <td>
                        Rp300.000
                    </td>
                    <td>
                        Rp300.000
                    </td>
                    <td>
                    </td>
                </tr>
                <tr>
                    <td>
                        3
                    </td>
                    <td>
                        Akomodasi
                        <br />
                        Hotel Batiga Cirebon
                    </td>
                    <td>
                        Rp650.000
                    </td>
                    <td>
                        2.00
                    </td>
                    <td>
                        Rp1.300.000
                    </td>
                    <td>
                        Rp1.300.000
                    </td>
                    <td>
                        2 Kamar
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
    <div class="details">
        <table>
            <tr>
                <td>
                    Subtotal
                </td>
                <td>
                    Rp2.400.000
                </td>
            </tr>
            <tr>
                <td>
                    Total
                </td>
                <td>
                    Rp2.400.000
                </td>
            </tr>
        </table>
    </div>
    <div class="details">
        <p>
            Dana dapat ditransfer ke nomor rekening:
        </p>
        <p>
            <strong>
                Mochamad Irvan Sandoval 1030006931402
            </strong>
        </p>
    </div>
    <div class="footer">
        <div class="signatures">
            <div>
                <p>
                    Diketahui oleh
                </p>
                <p>
                    Irvan Sandoval
                </p>
                <p>
                    Verifikator
                </p>
            </div>
            <div>
                <p>
                </p>
                <p>
                    Faisal Akbar
                </p>
                <p>
                    Operation Manager
                </p>
            </div>
            <div>
                <p>
                    Disetujui oleh
                </p>
                <p>
                    Irwandi
                </p>
                <p>
                    Direktur
                </p>
            </div>
            <div>
                <p>
                </p>
                <p>
                    Charles Teo
                </p>
                <p>
                </p>
            </div>
        </div>
    </div>
</body>

</html>
