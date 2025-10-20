@extends('layouts.app')

@section('title', 'Laporan Pindah Toko')

@section('content')
    <div class="container">
        <h3 class="mb-4">Laporan Pindah Toko</h3>

        <div class="card mb-4 shadow-sm border-0">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-end flex-wrap">
                    <!-- Form Filter -->
                    <form method="GET" class="row g-2 align-items-end">
                        <div class="col-auto">
                            <label class="form-label">Mulai</label>
                            <input type="date" name="start_date" value="{{ $startDate }}" class="form-control">
                        </div>
                        <div class="col-auto">
                            <label class="form-label">Sampai</label>
                            <input type="date" name="end_date" value="{{ $endDate }}" class="form-control">
                        </div>
                        <div class="col-auto">
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-funnel"></i> Filter
                            </button>
                        </div>
                    </form>

                    <!-- Tombol Download -->
                    <div class="mt-2 mt-md-0">
                        <a href="{{ route('warehouse.transfer.pdf', ['start_date' => $startDate, 'end_date' => $endDate]) }}"
                            class="btn btn-danger" target="_blank">
                            <i class="bi bi-file-earmark-pdf"></i> Download PDF
                        </a>
                    </div>
                </div>
            </div>
        </div>




        <div class="card">
            <div class="card-body table-responsive">
                <table class="table table-bordered table-hover align-middle mb-0">
                    <thead class="">
                        <tr>
                            <th>Kode Transfer</th>
                            <th>Produk</th>
                            <th class="text-center">Qty</th>
                            <th class="text-end">Harga</th>
                            <th class="text-end">Total</th>
                            <th>Catatan</th>
                            <th>Admin</th>
                            <th>Tanggal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($transfers as $t)
                            <tr>
                                <td>{{ $t->code }}</td>
                                <td>{{ $t->product->name ?? '-' }}</td>
                                <td class="text-center">{{ $t->qty }}</td>
                                <td class="text-end">Rp {{ number_format($t->price, 0, ',', '.') }}</td>
                                <td class="text-end">Rp {{ number_format($t->total, 0, ',', '.') }}</td>
                                <td>{{ $t->description }}</td>
                                <td>{{ $t->user->username ?? '-' }}</td>
                                <td>{{ $t->created_at->format('d-m-Y H:i') }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center text-muted">Tidak ada data</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- <div class="mt-3">
            {{ $transfers->appends(request()->query())->links() }}
        </div> --}}
    </div>
@endsection
