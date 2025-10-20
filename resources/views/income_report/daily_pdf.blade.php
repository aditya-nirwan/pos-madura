<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Laporan Harian</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            margin: 20px;
        }

        h3 {
            text-align: center;
            margin-bottom: 5px;
        }

        p {
            text-align: center;
            margin-top: 0;
            margin-bottom: 10px;
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

        .summary {
            margin-top: 15px;
            display: flex;
            justify-content: space-between;
        }

        .summary div {
            font-size: 14px;
            font-weight: bold;
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
    <h3>Laporan Transaksi Harian</h3>
    <p>Tanggal: {{ $date->translatedFormat('d F Y') }}</p>

    <table>
        <thead>
            <tr>
                <th>Tanggal</th>
                <th>Pendapatan</th>
                <th>PPN</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($dailyRevenues as $rev)
                <tr>
                    <td>{{ \Carbon\Carbon::parse($rev->date)->format('d-m-Y') }}</td>
                    <td>Rp {{ number_format($rev->income, 0, ',', '.') }}</td>
                    <td>Rp {{ number_format($rev->total_tax, 0, ',', '.') }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="3">Tidak ada data</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="summary">
        <div>Total Pendapatan: Rp {{ number_format($total_income, 0, ',', '.') }}</div>
        <div>Total PPN: Rp {{ number_format($total_tax, 0, ',', '.') }}</div>
    </div>

    <div class="footer">
        Dicetak pada: {{ now()->format('d-m-Y H:i') }}
    </div>
</body>

</html>
