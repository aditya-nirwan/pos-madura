@extends('layouts.app')

@section('title', 'Laporan Bulanan')

@section('content')
    <div class="container">
        {{-- Card Header & Filter --}}
        <div class="card shadow-sm border-0 mb-3">
            <div class="card-body d-flex justify-content-between align-items-center flex-wrap">
                <h3 class="fw-bold mb-2 mb-md-0">
                    Laporan Bulanan - {{ \Carbon\Carbon::create($year, $month)->translatedFormat('F Y') }}
                </h3>

                {{-- Filter Bulan & Tahun --}}
                <form method="GET" action="{{ route('laporan.bulanan') }}" class="d-flex gap-2">
                    <input type="month" name="month" class="form-control form-control-sm"
                        value="{{ $year }}-{{ str_pad($month, 2, '0', STR_PAD_LEFT) }}">
                    <button type="submit" class="btn btn-primary btn-sm">Filter</button>
                </form>
                <a href="{{ route('laporan.bulanan.pdf', ['year' => $year, 'month' => $month]) }}"
                    class="btn btn-danger btn-sm mb-3">
                    <i class="fas fa-file-pdf"></i> Download PDF
                </a>
            </div>
        </div>

        {{-- Card Tabel Laporan --}}
        <div class="card shadow-sm border-0 mb-3">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered align-middle mb-0">
                        <thead>
                            <tr>
                                <th>Tanggal</th>
                                <th>Pendapatan</th>
                                <th>PPN</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($daily as $rev)
                                <tr>
                                    <td>{{ \Carbon\Carbon::parse($rev->date)->translatedFormat('d F Y') }}</td>
                                    <td>Rp {{ number_format($rev->income, 0, ',', '.') }}</td>
                                    <td>Rp {{ number_format($rev->total_tax, 0, ',', '.') }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="text-center text-muted">Tidak ada data laporan bulan ini</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="card shadow-sm border-0">
            <div class="card-body">
                <div class="row text-center text-md-start">
                    <div class="col-md-6 mb-2 mb-md-0">
                        <h5>Total Pendapatan Bulan Ini:</h5>
                        <h4 class="fw-bold text-dark">Rp {{ number_format($total_income, 0, ',', '.') }}</h4>
                    </div>
                    <div class="col-md-6">
                        <h5>Total PPN Bulan Ini:</h5>
                        <h4 class="fw-bold text-primary">Rp {{ number_format($total_tax, 0, ',', '.') }}</h4>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
