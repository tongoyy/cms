<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>SP3 PDF</title>
    <style>
        /* Atur styling sesuai kebutuhan, misal CSS table dsb. */
        body {
            font-family: sans-serif;
            font-size: 12px;
        }

        .table,
        .td,
        .th {
            border: 1px solid #000;
            border-collapse: collapse;
        }

        .td,
        .th {
            padding: 8px;
        }
    </style>
</head>

<body>

    <h1>SP3 Detail</h1>
    <table>
        <tr>
            <td>SP3 Number</td>
            <td>{{ $sp3->SP3_Number }}</td>
        </tr>
        <tr>
            <td>Purchase Request</td>
            <td>{{ $sp3->Purchase_Request ?? '-' }}</td>
        </tr>
        <tr>
            <td>Purchase Order</td>
            <td>{{ $sp3->Purchase_Order ?? '-' }}</td>
        </tr>
        <tr>
            <td>Vendor</td>
            <td>{{ $sp3->Vendors }}</td>
        </tr>
        <tr>
            <td>Nama Supplier</td>
            <td>{{ $sp3->Nama_Supplier }}</td>
        </tr>
        <!-- Tambahkan field lain sesuai kebutuhan -->
    </table>

    <br>

    {{-- Kondisi 1: Jika Purchase_Request tidak kosong --}}
    @if (!empty($sp3->Purchase_Request))
        <h2>Purchase Request Items</h2>
        @if (isset($sp3->purchaseRequestItems) && $sp3->purchaseRequestItems->count())
            <table class="table">
                <thead>
                    <tr>
                        <th class="th">No</th>
                        <th class="th">Deskripsi Item</th>
                        <th class="th">Jumlah</th>
                        <!-- dll -->
                    </tr>
                </thead>
                <tbody>
                    @foreach ($sp3->purchaseRequestItems as $i => $item)
                        <tr>
                            <td class="td">{{ $i + 1 }}</td>
                            <td class="td">{{ $item->deskripsi ?? '' }}</td>
                            <td class="td">{{ $item->jumlah ?? '' }}</td>
                            <!-- dll -->
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <p>Tidak ada item Purchase Request.</p>
        @endif
    @endif

    <br>

    {{-- Kondisi 2: Jika Purchase_Order tidak kosong --}}
    @if (!empty($sp3->Purchase_Order))
        <h2>Purchase Order Items</h2>
        @if (isset($sp3->purchaseOrderItems) && $sp3->purchaseOrderItems->count())
            <table class="table">
                <thead>
                    <tr>
                        <th class="th">No</th>
                        <th class="th">Deskripsi Item</th>
                        <th class="th">Jumlah</th>
                        <!-- dll -->
                    </tr>
                </thead>
                <tbody>
                    @foreach ($sp3->purchaseOrderItems as $i => $item)
                        <tr>
                            <td class="td">{{ $i + 1 }}</td>
                            <td class="td">{{ $item->deskripsi ?? '' }}</td>
                            <td class="td">{{ $item->jumlah ?? '' }}</td>
                            <!-- dll -->
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <p>Tidak ada item Purchase Order.</p>
        @endif
    @endif

</body>

</html>
