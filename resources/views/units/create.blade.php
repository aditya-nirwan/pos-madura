@extends('layouts.app')

@section('title', 'Tambah Unit')

@section('content')
    <div class="container-fluid">
        @include('layouts.alert')

        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Tambah Unit</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('units.store') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="code" class="form-label">Kode Kategori</label>
                        <input type="text" class="form-control" id="code" name="code" value="{{ old('code') }}"
                            required>
                    </div>

                    <div class="mb-3">
                        <label for="name" class="form-label">Nama Kategori</label>
                        <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}"
                            required>
                    </div>

                    <button type="submit" class="btn btn-success">Simpan</button>
                </form>
            </div>
        </div>
    </div>
@endsection
