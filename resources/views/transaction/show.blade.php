@extends('layouts.app')

@section('title', 'Detail Transaksi')

@section('content')
    <div class="container my-4">
        <!-- Header -->
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h3 class="fw-bold text-primary">Detail Transaksi</h3>
            <a href="{{ route('transaction') }}" class="btn btn-secondary shadow-sm">
                <i class="bi bi-arrow-left"></i> Kembali
            </a>
        </div>

        <!-- Card Detail Transaksi -->
        <div class="card shadow-sm border-0 mb-4">
            <div class="card-header bg-primary text-white fw-bold">
                Informasi Transaksi
            </div>
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-md-4">
                        <p class="mb-1 text-muted">Kode Transaksi</p>
                        <h6 class="fw-bold">{{ $transaction->code }}</h6>
                    </div>
                    <div class="col-md-4">
                        <p class="mb-1 text-muted">Kasir</p>
                        <h6 class="fw-bold">{{ $transaction->cashier->name ?? 'Kasir Tidak Diketahui' }}</h6>
                    </div>
                    <div class="col-md-4">
                        <p class="mb-1 text-muted">Tanggal</p>
                        <h6 class="fw-bold">{{ $transaction->created_at->format('d M Y, H:i') }}</h6>
                    </div>
                    <div class="col-md-4">
                        <p class="mb-1 text-muted">Subtotal</p>
                        <h6 class="fw-bold text-dark">Rp {{ number_format($transaction->subtotal, 0, ',', '.') }}</h6>
                    </div>
                    <div class="col-md-4">
                        <p class="mb-1 text-muted">Diskon</p>
                        <h6 class="fw-bold text-danger">- Rp {{ number_format($transaction->total_discount, 0, ',', '.') }}
                        </h6>
                    </div>
                    <div class="col-md-4">
                        <p class="mb-1 text-muted">PPN</p>
                        <h6 class="fw-bold text-succes">- Rp {{ number_format($transaction->total_tax, 0, ',', '.') }}
                        </h6>
                    </div>
                    <div class="col-md-4">
                        <p class="mb-1 text-muted">Total</p>
                        <h6 class="fw-bold text-dark">Rp {{ number_format($transaction->total_cost, 0, ',', '.') }}</h6>
                    </div>
                </div>
            </div>
        </div>

        <!-- Card Detail Item Transaksi -->
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h3 class="fw-bold text-primary">Item Transaksi</h3>
        </div>
        <div class="card shadow-sm border-0">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table no-datatable table-striped table-hover align-middle">
                        <thead class="table-dark">
                            <tr>
                                <th>Kode Barang</th>
                                <th>Nama</th>
                                <th class="text-end">Harga</th>
                                <th class="text-center">Qty</th>
                                <th class="text-end">Subtotal</th>
                                <th class="text-end">Diskon</th>
                                <th class="text-end">PPN</th>
                                <th class="text-end">Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($transaction->items as $item)
                                <tr>
                                    <td class="fw-semibold">{{ $item->code }}</td>
                                    <td>{{ $item->name }}</td>
                                    <td class="text-end">Rp {{ number_format($item->price, 0, ',', '.') }}</td>
                                    <td class="text-center">{{ $item->qty }}</td>
                                    <td class="text-end">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</td>
                                    <td class="text-end text-danger">- Rp
                                        {{ number_format($item->discount_amount, 0, ',', '.') }}</td>
                                    <td class="text-end text-warning">Rp
                                        {{ number_format($item->tax_amount, 0, ',', '.') }}</td>
                                    <td class="fw-bold text-end text-success">Rp
                                        {{ number_format($item->total, 0, ',', '.') }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="text-center text-muted py-4">
                                        <i class="bi bi-inbox fs-4"></i>
                                        <p class="mb-0">Tidak ada item pada transaksi ini</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
@endsection
