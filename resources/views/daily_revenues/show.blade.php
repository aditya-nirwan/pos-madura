@extends('layouts.app')

@section('title', 'Rekap Harian')

@section('content')
    <div class="container">
        <h4 class="fw-bold mb-3">Rekap Harian</h4>
        @include('layouts.alert')

        {{-- Form Filter Tanggal --}}
        <div class="card shadow-sm border-0 mb-4">
            <div class="card-body">
                <form method="GET" class="d-flex flex-wrap align-items-center gap-2">
                    <label for="date" class="form-label mb-0 fw-semibold">Pilih Tanggal:</label>
                    <input type="date" name="date" id="date" value="{{ $date }}"
                        class="form-control w-auto">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-filter me-1"></i> Filter
                    </button>
                </form>
            </div>
        </div>

        {{-- Preview Hasil Rekap --}}
        <div class="card shadow-sm border-0 mb-4">
            <div class="card-body">
                <h5 class="fw-bold mb-3">
                    Hasil Rekap: <span class="text-dark">{{ $date }}</span>
                </h5>
                <div class="row mb-3">
                    <div class="col-md-6">
                        <p class="mb-1"><b>Total Income:</b></p>
                        <h5 class="text-dark">Rp{{ number_format($income, 0, ',', '.') }}</h5>
                    </div>
                    <div class="col-md-6">
                        <p class="mb-1"><b>Total Pajak:</b></p>
                        <h5 class="text-danger">Rp{{ number_format($totalTax, 0, ',', '.') }}</h5>
                    </div>
                </div>

                <form method="POST" action="{{ route('daily-revenues.store') }}">
                    @csrf
                    <input type="hidden" name="date" value="{{ $date }}">
                    <button type="submit" class="btn btn-success">
                        <i class="fas fa-save me-1"></i> Simpan Rekap
                    </button>
                </form>
            </div>
        </div>

        {{-- Daftar Transaksi --}}
        <div class="card shadow-sm border-0">
            <div class="card-body">
                <h5 class="fw-bold mb-3">Daftar Transaksi</h5>
                <div class="table-responsive">
                    <table class="table table-bordered table-striped align-middle">
                        <thead class="table-secondary text-center">
                            <tr>
                                <th>Kode</th>
                                <th>Subtotal</th>
                                <th>Diskon</th>
                                <th>Pajak</th>
                                <th>Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($transactions as $trx)
                                <tr>
                                    <td class="text-center">{{ $trx->code }}</td>
                                    <td class="text-end">Rp{{ number_format($trx->subtotal, 0, ',', '.') }}</td>
                                    <td class="text-end">Rp{{ number_format($trx->total_discount, 0, ',', '.') }}</td>
                                    <td class="text-end">Rp{{ number_format($trx->total_tax, 0, ',', '.') }}</td>
                                    <td class="text-end fw-bold">Rp{{ number_format($trx->total_cost, 0, ',', '.') }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center text-muted">Tidak ada transaksi</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
