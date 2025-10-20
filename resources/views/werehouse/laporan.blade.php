@extends('layouts.app')

@section('title', 'Laporan Gudang')

@section('content')
    <div class="container-fluid">
        <div class="col-md-12">

            @include('layouts.alert')

            <div class="d-flex justify-content-between align-items-center mb-3">
                <h4>Laporan Masuk</h4>
            </div>



            <form action="{{ route('warehouse.show') }}" method="GET" class="mb-3">
                <div class="row g-2 align-items-end">
                    <!-- Pilih Jenis Filter -->
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
                        <a href="{{ route('warehouse.show') }}" class="btn btn-secondary w-100">
                            <i class="bi bi-arrow-repeat"></i> Reset
                        </a>
                    </div>

                    <div class="col-md-2">
                        <a href="{{ route('warehouse.pdf', ['filter' => $filter, 'date' => $date, 'month' => $month]) }}"
                            class="btn btn-danger" target="_blank">
                            <i class="bi bi-file-earmark-pdf"></i> Download PDF
                        </a>
                    </div>
                </div>
            </form>


            <div class="card">
                <div class="card-body table-responsive">
                    <table class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th>Kode Transaksi</th>
                                <th>Tanggal</th>
                                <th>User</th>
                                <th>Nama Barang</th>
                                <th>Qty Pack</th>
                                <th>Isi per Pack</th>
                                <th>Total Pcs</th>
                                <th>Harga Satuan</th>
                                <th>Biaya Lain</th>
                                <th>Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($details as $d)
                                <tr>
                                    @php
                                        $productCount = $d->stockIn->details->count();
                                        $costPerProduct =
                                            $productCount > 0 ? $d->stockIn->other_cost_total / $productCount : 0;
                                        $totalPcs = $d->qty_pack * $d->qty_per_pack;
                                    @endphp
                                    <td>{{ $d->stockIn->code }}</td>
                                    <td>{{ $d->stockIn->created_at->format('d-m-Y') }}</td>
                                    <td>{{ $d->stockIn->user->username }}</td>
                                    <td>{{ $d->product->name ?? '-' }}</td>
                                    <td>{{ $d->qty_pack }}</td>
                                    <td>{{ $d->qty_per_pack }}</td>
                                    <td>{{ $totalPcs }}</td>
                                    <td>Rp {{ number_format($d->buy_price, 0, ',', '.') }}</td>
                                    <td>Rp {{ number_format($costPerProduct, 0, ',', '.') }}</td>
                                    <td>Rp {{ number_format($totalPcs * $d->buy_price + $costPerProduct, 0, ',', '.') }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="10" class="text-center">Tidak ada data</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>

                    <script>
                        function toggleInput() {
                            const filter = document.getElementById('filter').value;
                            document.getElementById('dateInput').style.display = filter === 'day' ? '' : 'none';
                            document.getElementById('monthInput').style.display = filter === 'month' ? '' : 'none';
                        }
                    </script>
                </div>
            </div>
        </div>
    </div>
@endsection
