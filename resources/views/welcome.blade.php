@extends('layouts.app')

@section('title', 'Dashboard')
@section('content')
    <div class="container">

        <h4 class="mb-4">Laporan Pendapatan Tahun {{ $year }}</h4>
        <div class="row">
            <!-- Card Pendapatan -->
            <div class="col-md-6 mb-3">
                <div class="card shadow-sm border-0">
                    <div class="card-body">
                        <h6 class="text-muted">Total Pendapatan</h6>
                        <h4 class="fw-bold text-primary">Rp {{ number_format($total_income, 0, ',', '.') }}</h4>
                    </div>
                </div>
            </div>

            <!-- Card Pajak -->
            <div class="col-md-6 mb-3">
                <div class="card shadow-sm border-0">
                    <div class="card-body">
                        <h6 class="text-muted">Total Pajak</h6>
                        <h4 class="fw-bold text-danger">Rp {{ number_format($total_tax, 0, ',', '.') }}</h4>
                    </div>
                </div>
            </div>
        </div>
        <!-- Grafik Line Chart -->
        <div class="card shadow-sm border-0 mb-4" data-aos="fade-up">
            <div class="card-body">
                <h6 class="mb-3">Grafik Pendapatan Bulanan</h6>
                <canvas id="incomeChart" height="100"></canvas>
            </div>
        </div>

        <!-- Card Summary di bawah grafik -->
        <div class="row">
            <div class="col-md-3 mb-3" data-aos="fade-up" data-aos-delay="100">
                <div class="card shadow-sm border-0 text-center h-100">
                    <div class="card-body">
                        <h6 class="text-muted">Total Produk</h6>
                        <h4 class="fw-bold">{{ $total_products ?? 0 }}</h4>
                    </div>
                </div>
            </div>
            <div class="col-md-3 mb-3" data-aos="fade-up" data-aos-delay="200">
                <div class="card shadow-sm border-0 text-center h-100">
                    <div class="card-body">
                        <h6 class="text-muted">Stok Gudang</h6>
                        <h4 class="fw-bold">{{ $total_stock ?? 0 }}</h4>
                    </div>
                </div>
            </div>
            <div class="col-md-3 mb-3" data-aos="fade-up" data-aos-delay="300">
                <div class="card shadow-sm border-0 text-center h-100">
                    <div class="card-body">
                        <h6 class="text-muted">Transaksi Hari Ini</h6>
                        <h4 class="fw-bold">{{ $today_transactions ?? 0 }}</h4>
                    </div>
                </div>
            </div>
            <div class="col-md-3 mb-3" data-aos="fade-up" data-aos-delay="400">
                <div class="card shadow-sm border-0 text-center h-100">
                    <div class="card-body">
                        <h6 class="text-muted">Pendapatan Hari Ini</h6>
                        <h4 class="fw-bold text-success">Rp {{ number_format($today_income ?? 0, 0, ',', '.') }}</h4>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <!-- AOS.js (Animasi Fade-Up) -->
    <link href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>

    <script>
        // Init AOS
        AOS.init({
            duration: 800,
            once: true
        });

        // Data Chart
        const monthly = @json($monthly);

        const labels = monthly.map(m => new Date(0, m.month - 1).toLocaleString('id-ID', {
            month: 'long'
        }));
        const incomeData = monthly.map(m => m.total_income);
        const taxData = monthly.map(m => m.total_tax);

        const ctx = document.getElementById('incomeChart').getContext('2d');
        new Chart(ctx, {
            type: 'line',
            data: {
                labels: labels,
                datasets: [{
                        label: 'Pendapatan',
                        data: incomeData,
                        borderColor: 'rgba(54, 162, 235, 1)',
                        backgroundColor: 'rgba(54, 162, 235, 0.2)',
                        tension: 0.3,
                        fill: true,
                    },
                    {
                        label: 'Pajak',
                        data: taxData,
                        borderColor: 'rgba(255, 99, 132, 1)',
                        backgroundColor: 'rgba(255, 99, 132, 0.2)',
                        tension: 0.3,
                        fill: true,
                    }
                ]
            },
            options: {
                responsive: true,
                plugins: {
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                let value = context.raw || 0;
                                return 'Rp ' + value.toLocaleString('id-ID');
                            }
                        }
                    }
                },
                scales: {
                    y: {
                        ticks: {
                            callback: function(value) {
                                return 'Rp ' + value.toLocaleString('id-ID');
                            }
                        }
                    }
                }
            }
        });
    </script>
@endsection
