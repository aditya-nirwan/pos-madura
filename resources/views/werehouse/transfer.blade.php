@extends('layouts.app')

@section('title', 'Pindah Toko')

@section('content')
    <div class="container">
        @include('layouts.alert')

        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Pindah Stok Gudang ke Toko</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('transfer.store', $product->id) }}" method="POST">
                    @csrf

                    <div class="form-group mb-3">
                        <label>Nama Barang</label>
                        <input type="text" class="form-control" value="{{ $product->product->name ?? '-' }}" readonly>
                    </div>

                    <div class="form-group mb-3">
                        <label>Stok Gudang</label>
                        <input type="number" class="form-control" value="{{ $product->stock }}" readonly>
                    </div>

                    <div class="form-group mb-3">
                        <label>Jumlah Pindah</label>
                        <input type="number" name="qty" class="form-control" min="1" max="{{ $product->stock }}"
                            required>
                    </div>

                    <div class="form-group mb-3">
                        <label>Harga Satuan</label>
                        <input type="number" name="price" step="0.01" class="form-control"
                            value="{{ $product->buy_price }}">
                    </div>

                    <div class="form-group mb-3">
                        <label>Keterangan</label>
                        <textarea name="description" class="form-control"></textarea>
                    </div>

                    <button type="submit" class="btn btn-primary">Transfer ke Toko</button>
                </form>
            </div>
        </div>
    </div>
@endsection
