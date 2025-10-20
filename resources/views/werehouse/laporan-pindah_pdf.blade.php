<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Laporan Pindah Toko</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 11px;
            margin: 15px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }

        th,
        td {
            border: 1px solid #000;
            padding: 5px;
            text-align: center;
        }

        th {
            background-color: #f2f2f2;
        }

        h3 {
            text-align: center;
            margin-bottom: 5px;
        }

        .footer {
            position: fixed;
            bottom: 10px;
            right: 10px;
            font-size: 10px;
            color: gray;
        }
    </style>
</head>

<body>
    <h3>Laporan Pindah Toko</h3>
    <p style="text-align:center">
        Periode: {{ \Carbon\Carbon::parse($startDate)->format('d-m-Y') }} s/d
        {{ \Carbon\Carbon::parse($endDate)->format('d-m-Y') }}
    </p>

    <table>
        <thead>
            <tr>
                <th>Kode Transfer</th>
                <th>Produk</th>
                <th>Qty</th>
                <th>Harga</th>
                <th>Total</th>
                <th>Catatan</th>
                <th>Admin</th>
                <th>Tanggal</th>
            </tr>
        </thead>
        <tbody>
            @forelse($transfers as $t)
                <tr>
                    <td>{{ $t->code }}</td>
                    <td>{{ $t->product->name ?? '-' }}</td>
                    <td>{{ $t->qty }}</td>
                    <td>Rp {{ number_format($t->price, 0, ',', '.') }}</td>
                    <td>Rp {{ number_format($t->total, 0, ',', '.') }}</td>
                    <td>{{ $t->description }}</td>
                    <td>{{ $t->user->username ?? '-' }}</td>
                    <td>{{ $t->created_at->format('d-m-Y H:i') }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="8">Tidak ada data</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="footer">
        Dicetak pada: {{ now()->format('d-m-Y H:i') }}
    </div>
</body>

</html>
