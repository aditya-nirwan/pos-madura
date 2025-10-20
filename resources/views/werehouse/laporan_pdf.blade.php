<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Laporan Gudang</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }

        th,
        td {
            border: 1px solid #000;
            padding: 6px;
            text-align: center;
        }

        th {
            background-color: #f2f2f2;
        }

        h3 {
            text-align: center;
            margin-bottom: 5px;
        }
    </style>
</head>

<body>
    <h3>Laporan Barang Masuk</h3>
    @if ($filter === 'day' && $date)
        <p style="text-align: center">Tanggal: {{ \Carbon\Carbon::parse($date)->format('d-m-Y') }}</p>
    @elseif($filter === 'month' && $month)
        <p style="text-align: center">Bulan: {{ \Carbon\Carbon::parse($month)->format('F Y') }}</p>
    @else
        <p style="text-align: center">Semua Data</p>
    @endif

    <table>
        <thead>
            <tr>
                <th>Kode Transaksi</th>
                <th>Tanggal</th>
                <th>User</th>
                <th>Nama Barang</th>
                <th>Qty Pack</th>
                <th>Isi per Pack</th>
                <th>Total Pcs</th>
                <th>Harga Satuan</th>
                <th>Biaya Lain</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            @forelse($details as $d)
                @php
                    $productCount = $d->stockIn->details->count();
                    $costPerProduct = $productCount > 0 ? $d->stockIn->other_cost_total / $productCount : 0;
                    $totalPcs = $d->qty_pack * $d->qty_per_pack;
                @endphp
                <tr>
                    <td>{{ $d->stockIn->code }}</td>
                    <td>{{ $d->stockIn->created_at->format('d-m-Y') }}</td>
                    <td>{{ $d->stockIn->user->username }}</td>
                    <td>{{ $d->product->name ?? '-' }}</td>
                    <td>{{ $d->qty_pack }}</td>
                    <td>{{ $d->qty_per_pack }}</td>
                    <td>{{ $totalPcs }}</td>
                    <td>Rp {{ number_format($d->buy_price, 0, ',', '.') }}</td>
                    <td>Rp {{ number_format($costPerProduct, 0, ',', '.') }}</td>
                    <td>Rp {{ number_format($totalPcs * $d->buy_price + $costPerProduct, 0, ',', '.') }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="10">Tidak ada data</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</body>

</html>
