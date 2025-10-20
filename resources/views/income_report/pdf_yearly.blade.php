<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Laporan Tahunan {{ $year }}</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
        }

        h2 {
            text-align: center;
            margin-bottom: 15px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 15px;
        }

        th,
        td {
            border: 1px solid #000;
            padding: 6px;
            text-align: center;
        }

        th {
            background-color: #f5f5f5;
        }

        .summary {
            margin-top: 10px;
            font-size: 13px;
        }
    </style>
</head>

<body>
    <h2>Laporan Tahunan {{ $year }}</h2>

    <table>
        <thead>
            <tr>
                <th>Bulan</th>
                <th>Pendapatan</th>
                <th>PPN</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($monthly as $rev)
                <tr>
                    <td>{{ \Carbon\Carbon::create()->month($rev->month)->translatedFormat('F') }}</td>
                    <td>Rp {{ number_format($rev->total_income, 0, ',', '.') }}</td>
                    <td>Rp {{ number_format($rev->total_tax, 0, ',', '.') }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="3" style="text-align:center;">Tidak ada data laporan tahunan</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="summary">
        <p><b>Total Pendapatan:</b> Rp {{ number_format($total_income, 0, ',', '.') }}</p>
        <p><b>Total PPN:</b> Rp {{ number_format($total_tax, 0, ',', '.') }}</p>
    </div>
</body>

</html>
