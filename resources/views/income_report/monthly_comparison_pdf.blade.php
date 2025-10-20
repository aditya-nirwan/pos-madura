<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Perbandingan Bulanan</title>
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

    {{-- Header Judul --}}
    <div class="title">
        <h2>Laporan Perbandingan Bulanan</h2>
        <p>Bulan {{ \Carbon\Carbon::create($year, $month)->translatedFormat('F Y') }}</p>
    </div>

    {{-- Ringkasan Keuangan --}}
    <table class="summary">
        <thead>
            <tr>
                <th>Total Modal</th>
                <th>Total Pendapatan</th>
                <th>Laba Bersih</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Rp {{ number_format($modalPerBulan, 0, ',', '.') }}</td>
                <td>Rp {{ number_format($pendapatanPerBulan, 0, ',', '.') }}</td>
                <td>Rp {{ number_format($laba, 0, ',', '.') }}</td>
            </tr>
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
