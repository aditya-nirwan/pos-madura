@extends('layouts.app')

@section('title', 'Laporan Perbandingan')

@section('content')
    <div class="container">

        {{-- Card Header & Filter --}}
        <div class="card shadow-sm border-0 mb-4">
            <div class="card-body d-flex flex-wrap justify-content-between align-items-center">
                <h3 class="fw-bold mb-2 mb-md-0">
                    Laporan Bulan {{ \Carbon\Carbon::create($year, $month)->translatedFormat('F Y') }}
                </h3>

                <form action="{{ route('perbandingan.bulanan') }}" method="GET" class="d-flex gap-2">
                    <input type="month" name="bulan" class="form-control form-control-sm"
                        value="{{ $year }}-{{ str_pad($month, 2, '0', STR_PAD_LEFT) }}" max="{{ date('Y-m') }}"
                        style="width:160px">
                    <button type="submit" class="btn btn-primary btn-sm">Filter</button>
                </form>
                <a href="{{ route('perbandingan.bulanan.pdf', ['bulan' => $year . '-' . str_pad($month, 2, '0', STR_PAD_LEFT)]) }}"
                    class="btn btn-danger btn-sm" target="_blank">
                    <i class="fas fa-file-pdf"></i> Download PDF
                </a>

            </div>
        </div>

        <div class="row g-3">
            <div class="col-md-4">
                <div class="card shadow-sm border-0 h-100">
                    <div class="card-body text-center">
                        <h6 class="fw-bold text-secondary">Total Modal</h6>
                        <h4 class="fw-bold text-dark">
                            Rp {{ number_format($modalPerBulan, 0, ',', '.') }}
                        </h4>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card shadow-sm border-0 h-100">
                    <div class="card-body text-center">
                        <h6 class="fw-bold text-secondary">Total Pendapatan</h6>
                        <h4 class="fw-bold text-success">
                            Rp {{ number_format($pendapatanPerBulan, 0, ',', '.') }}
                        </h4>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card shadow-sm border-0 h-100">
                    <div class="card-body text-center">
                        <h6 class="fw-bold text-secondary">Laba Bersih</h6>
                        <h4 class="fw-bold text-primary">
                            Rp {{ number_format($laba, 0, ',', '.') }}
                        </h4>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
