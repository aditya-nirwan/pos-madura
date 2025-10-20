@extends('layouts.app')

@section('title', 'Produk Gudang')

@section('content')
    <div class="container-fluid">
        <div class="col-md-12">

            @include('layouts.alert')

            <div class="d-flex justify-content-between align-items-center mb-3">
                <h4>Daftar Stok Gudang</h4>
                <a href="{{ url('gudang/create') }}" class="btn btn-primary">Tambah Stok Gudang</a>
            </div>

            <div class="card">
                <div class="card-body table-responsive">
                    <table class="table table-striped table-hover">
                        <thead class="">
                            <tr>
                                <th>Kode</th>
                                <th>Nama Barang</th>
                                <th>Kategori</th>
                                <th>Satuan</th>
                                <th>Harga Beli</th>
                                <th>Stok</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($products as $p)
                                <tr>
                                    <td>{{ $p->product->code }}</td>
                                    <td>{{ $p->product->name }}</td>
                                    <td>{{ $p->category->name ?? '-' }}</td>
                                    <td>{{ $p->unit->name ?? '-' }}</td>
                                    <td>Rp {{ number_format($p->buy_price, 0, ',', '.') }}</td>
                                    <td>{{ $p->stock }}</td>
                                    <td>
                                        <form action="{{ route('warehouse.destroy', $p->id) }}" method="POST"
                                            style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" onclick="return confirm('Yakin hapus?')"
                                                class="btn btn-danger btn-sm">
                                                Hapus
                                            </button>
                                        </form>
                                        <a href="{{ route('warehouse.transfer', $p->id) }}" class="btn btn-success btn-sm">
                                            Pindah Toko
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center">Belum ada data produk gudang</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>

                </div>
            </div>
        </div>
    @endsection
