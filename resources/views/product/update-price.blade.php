@extends('layouts.app')

@section('title', 'Update Harga Produk')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5>Update Harga Produk</h5>
                    <a href="{{ url('product') }}" class="btn btn-sm btn-secondary">
                        <i class="fa fa-arrow-left"></i> Kembali
                    </a>
                </div>

                <div class="card-block">
                    <form action="{{ route('update-price', $product->id) }}" method="POST">
                        @csrf

                        <div class="form-group">
                            <label>Nama Barang</label>
                            <input type="text" class="form-control" value="{{ $product->name }}" disabled>
                        </div>

                        <div class="form-group">
                            <label>Harga Beli</label>
                            <input type="number" step="0.01" name="purchase_price" class="form-control"
                                value="{{ $werehouse->buy_price ?? '' }}" required>
                        </div>
                        <div class="form-group">
                            <label>Harga Jual</label>
                            <input type="number" step="0.01" name="selling_price" class="form-control" required>
                        </div>

                        <button type="submit" class="btn btn-primary">Update Harga</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
