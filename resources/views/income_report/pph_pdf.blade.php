<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Laporan PPh Final {{ $year }}</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            margin: 20px;
            font-size: 12px;
        }

        .title {
            text-align: center;
            margin-bottom: 10px;
        }

        .title h2 {
            margin: 0;
            font-size: 18px;
        }

        .title p {
            margin: 3px 0 0;
            font-size: 12px;
            color: #555;
        }

        .summary {
            margin-top: 15px;
            width: 100%;
            border-collapse: collapse;
        }

        .summary th,
        .summary td {
            border: 1px solid #000;
            padding: 8px;
            text-align: right;
        }

        .summary th {
            background-color: #f2f2f2;
            text-align: center;
        }

        .footer {
            margin-top: 30px;
            text-align: right;
            font-size: 12px;
        }

        .bold {
            font-weight: bold;
        }
    </style>
</head>

<body>
    <h3>Laporan PPh Final - {{ $year }}</h3>
    <table class="summary">
        <thead>
            <tr>
                <th>Bulan</th>
                <th>Total Income</th>
                <th>Total PPN</th>
                <th>Omzet</th>
                <th>PPh Final (0,5%)</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($revenues as $rev)
                <tr>
                    <td>{{ \Carbon\Carbon::create()->month($rev->bulan)->translatedFormat('F') }}</td>
                    <td>Rp {{ number_format($rev->total_income, 0, ',', '.') }}</td>
                    <td>Rp {{ number_format($rev->total_tax, 0, ',', '.') }}</td>
                    <td>Rp {{ number_format($rev->omzet, 0, ',', '.') }}</td>
                    <td>Rp {{ number_format($rev->pph, 0, ',', '.') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    {{-- Tanda Tangan --}}
    <div class="footer">
        <p>{{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}</p>
        <p><strong>Manajer Keuangan</strong></p>
        <br><br><br>
        <p>(_______________________)</p>
    </div>
</body>

</html>
