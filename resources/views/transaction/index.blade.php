@extends('layouts.app')

@section('title', 'Transaksi')

@section('content')
    <div class="container my-4">
        <!-- Header -->
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h3 class="fw-bold">Daftar Transaksi</h3>
        </div>
        <!-- Filter Form -->
        <div class="card mb-3">

            <div class="card-body">
                <form action="{{ route('transaction') }}" method="GET" class="mb-0">
                    <div class="row g-2 align-items-end">
                        <div class="col-md-3">
                            <label class="form-label">Filter Berdasarkan</label>
                            <select name="filter" id="filter" class="form-select" onchange="toggleInput()">
                                <option value="all" {{ $filter === 'all' ? 'selected' : '' }}>Semua</option>
                                <option value="day" {{ $filter === 'day' ? 'selected' : '' }}>Per Hari</option>
                                <option value="month" {{ $filter === 'month' ? 'selected' : '' }}>Per Bulan</option>
                            </select>
                        </div>

                        <!-- Input Tanggal -->
                        <div class="col-md-3" id="dateInput" style="{{ $filter === 'day' ? '' : 'display:none' }}">
                            <label class="form-label">Pilih Tanggal</label>
                            <input type="date" name="date" class="form-control" value="{{ $date }}">
                        </div>

                        <!-- Input Bulan -->
                        <div class="col-md-3" id="monthInput" style="{{ $filter === 'month' ? '' : 'display:none' }}">
                            <label class="form-label">Pilih Bulan</label>
                            <input type="month" name="month" class="form-control" value="{{ $month }}">
                        </div>

                        <div class="col-md-2">
                            <button type="submit" class="btn btn-primary w-100">
                                <i class="bi bi-filter"></i> Filter
                            </button>
                        </div>

                        <div class="col-md-2">
                            <a href="{{ route('transaction') }}" class="btn btn-secondary w-100">
                                <i class="bi bi-arrow-repeat"></i> Reset
                            </a>
                        </div>
                    </div>
                </form>
            </div>
        </div>


        <!-- Card -->
        <div class="card shadow-sm border-0">
            <div class="card-body">
                <!-- Table Responsive -->
                <div class="table-responsive">
                    <table class="table table-striped table-hover align-middle">
                        <thead>
                            <tr>
                                <th>Kode</th>
                                <th>Kasir</th>
                                <th class="text-end">Subtotal</th>
                                <th class="text-end">Diskon</th>
                                <th class="text-end">PPN</th>
                                <th class="text-end">Total</th>
                                <th>Tanggal</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($transactions as $trx)
                                <tr>
                                    <td>{{ $trx->code }}</td>
                                    <td>{{ $trx->cashier->name ?? '-' }}</td>
                                    <td class="text-end">{{ number_format($trx->subtotal, 0, ',', '.') }}</td>
                                    <td class="text-end text-danger">
                                        -{{ number_format($trx->total_discount, 0, ',', '.') }}
                                    </td>
                                    <td class="text-end text-success">
                                        {{ number_format($trx->total_tax, 0, ',', '.') }}
                                    </td>
                                    <td class="text-end fw-bold">
                                        {{ number_format($trx->total_cost, 0, ',', '.') }}
                                    </td>
                                    <td>{{ $trx->created_at->format('d M Y, H:i') }}</td>
                                    <td class="text-center">
                                        <a href="{{ route('transaction.show', $trx->id) }}"
                                            class="btn btn-info btn-sm shadow-sm">
                                            <i class="bi bi-eye"></i> Detail
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="text-center text-muted py-4">
                                        <i class="bi bi-inbox fs-4"></i>
                                        <p class="mb-0">Belum ada transaksi</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>

                </div>

                <!-- Pagination -->
                <div class="d-flex justify-content-end mt-3">
                    {{ $transactions->links('pagination::bootstrap-5') }}
                </div>
            </div>
        </div>
    </div>

    <script>
        function toggleInput() {
            const filter = document.getElementById('filter').value;
            document.getElementById('dateInput').style.display = filter === 'day' ? '' : 'none';
            document.getElementById('monthInput').style.display = filter === 'month' ? '' : 'none';
        }
    </script>
@endsection
