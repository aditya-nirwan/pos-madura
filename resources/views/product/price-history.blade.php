@extends('layouts.app')

@section('title', 'Riwayat Harga')

@section('content')
    <div class="container-fluid">
        <div class="col-md-12">

            @include('layouts.alert')

            <div class="d-flex justify-content-between align-items-center mb-3">
                <h3>Riwayat Harga: {{ $product->name }}</h3>
            </div>

            <div class="card">
                <div class="card-body table-responsive">
                    <table class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th>Tanggal Berlaku</th>
                                <th>Harga Beli</th>
                                <th>Harga Jual</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($histories as $r)
                                <tr>
                                    <td>{{ $r->effective_date }}</td>
                                    <td>Rp {{ number_format($r->purchase_price, 0, ',', '.') }}</td>
                                    <td>Rp {{ number_format($r->selling_price, 0, ',', '.') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
