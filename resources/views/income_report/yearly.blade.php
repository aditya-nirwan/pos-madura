@extends('layouts.app')

@section('title', 'Laporan Tahunan')

@section('content')
    <div class="container">

        {{-- Card Header & Filter --}}
        <div class="card shadow-sm border-0 mb-3">
            <div class="card-body d-flex justify-content-between align-items-center flex-wrap">
                <h3 class="fw-bold mb-2 mb-md-0">
                    Laporan Tahunan - {{ $year }}
                </h3>

                {{-- Filter Tahun --}}
                <form method="GET" action="{{ route('laporan.tahunan') }}" class="d-flex gap-2">
                    <input type="number" name="year" class="form-control form-control-sm" value="{{ $year }}"
                        min="2000" max="{{ date('Y') }}" style="width:120px">
                    <button type="submit" class="btn btn-primary btn-sm">Filter</button>
                </form>
                <a href="{{ route('laporan.tahunan.pdf', ['year' => $year]) }}" class="btn btn-danger btn-sm mb-3">
                    <i class="fas fa-file-pdf"></i> Export PDF
                </a>

            </div>
        </div>

        {{-- Card Tabel Laporan --}}
        <div class="card shadow-sm border-0">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered align-middle mb-0">
                        <thead>
                            <tr class="table-primary text-center">
                                <th>Bulan</th>
                                <th>Pendapatan</th>
                                <th>PPN</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($monthly as $rev)
                                <tr>
                                    <td class="fw-bold text-center">
                                        {{ \Carbon\Carbon::create()->month($rev->month)->translatedFormat('F') }}
                                    </td>
                                    <td>Rp {{ number_format($rev->total_income, 0, ',', '.') }}</td>
                                    <td>Rp {{ number_format($rev->total_tax, 0, ',', '.') }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="text-center text-muted">Tidak ada data laporan tahun ini</td>
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
                        <h5>Total Pendapatan Tahun Ini:</h5>
                        <h4 class="fw-bold text-dark">Rp {{ number_format($total_income, 0, ',', '.') }}</h4>
                    </div>
                    <div class="col-md-6">
                        <h5>Total PPN Tahun Ini:</h5>
                        <h4 class="fw-bold text-primary">Rp {{ number_format($total_tax, 0, ',', '.') }}</h4>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
