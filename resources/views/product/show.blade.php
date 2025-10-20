@extends('layouts.app')

@section('title', 'Produk')

@section('content')
    <div class="container-fluid">
        <div class="col-md-12">

            @include('layouts.alert')

            <div class="d-flex justify-content-between align-items-center mb-3">
                <h4>Daftar Produk</h4>
                <a href="{{ url('product/create') }}" class="btn btn-primary">Tambah Produk</a>
            </div>

            <div class="card">
                <div class="card-body table-responsive">
                    <table class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Kode</th>
                                <th>Kategori</th>
                                <th>Nama Produk</th>
                                <th>Harga Beli</th>
                                <th>Harga Jual</th>
                                <th>Diskon</th>
                                <th>PPN</th>
                                <th>Stok</th>
                                <th>Gambar</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($show as $key => $product)
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td title="{{ $product->code }}">
                                        {{ \Illuminate\Support\Str::limit($product->code, 6, '...') }}
                                    </td>
                                    <td>{{ $product->category->name ?? '-' }}</td>
                                    <td title="{{ $product->name }}">
                                        {{ \Illuminate\Support\Str::limit($product->name, 15, '...') }}
                                    </td>
                                    <td>Rp {{ number_format($product->buy_price, 0, ',', '.') }}</td>
                                    <td>Rp {{ number_format($product->sell_price, 0, ',', '.') }}</td>

                                    {{-- Diskon --}}
                                    <td>
                                        @if ($product->discount_type === 'percent')
                                            {{ $product->discount_percent }}%
                                            <br>
                                            <small class="text-muted">Rp
                                                {{ number_format($product->discount_amount, 0, ',', '.') }}</small>
                                        @else
                                            Rp {{ number_format($product->discount_amount, 0, ',', '.') }}
                                        @endif
                                    </td>
                                    {{-- PPN --}}
                                    <td>
                                        @if ($product->tax_type === 'percent')
                                            {{ $product->tax_percent }}%
                                            <br>
                                            <small class="text-muted">Rp
                                                {{ number_format($product->tax_amount, 0, ',', '.') }}</small>
                                        @else
                                            Rp {{ number_format($product->tax_amount, 0, ',', '.') }}
                                        @endif
                                    </td>

                                    <td>{{ $product->stock }}</td>


                                    <td>
                                        @if ($product->image)
                                            <a href="{{ asset('images/' . $product->image) }}" target="_blank">
                                                <img src="{{ asset('images/' . $product->image) }}" alt="Produk"
                                                    width="50" class="img-thumbnail">
                                            </a>
                                        @else
                                            <span class="text-muted">Tidak ada</span>
                                        @endif
                                    </td>

                                    <td>
                                        <div class="d-flex flex-wrap gap-1">
                                            {{-- Edit --}}
                                            <a href="{{ route('product.edit', $product->id) }}"
                                                class="btn btn-sm btn-warning" title="Edit">
                                                <i class="fa fa-edit"></i>
                                            </a>

                                            {{-- Hapus --}}
                                            <form action="{{ route('product.delete', $product->id) }}" method="POST"
                                                onsubmit="return confirm('Hapus produk ini?')" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger" title="Hapus">
                                                    <i class="fa fa-trash"></i>
                                                </button>
                                            </form>

                                            {{-- Update Harga --}}
                                            <a href="{{ route('price-form', $product->id) }}"
                                                class="btn btn-sm btn-secondary" title="Update Harga">
                                                <i class="fa fa-dollar-sign"></i>
                                            </a>

                                            {{-- Riwayat Harga --}}
                                            <a href="{{ route('price-history', $product->id) }}"
                                                class="btn btn-sm btn-info text-white" title="Riwayat Harga">
                                                <i class="fa fa-history"></i>
                                            </a>

                                            {{-- Barcode --}}
                                            <a href="{{ route('product.barcode', $product->id) }}"
                                                class="btn btn-sm btn-dark" target="_blank">
                                                <i class="fa fa-barcode"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="11" class="text-center">Belum ada data produk.</td>
                                </tr>
                            @endforelse
                        </tbody>

                    </table>
                </div>
            </div>

        </div>
    </div>
@endsection
