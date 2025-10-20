@extends('layouts.app')

@section('title', 'Edit Jabatan')

@section('content')
    <div class="container my-4">
        <div class="card">
            <div class="card-header">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5>Edit Data</h5>
                    <a href="{{ route('position.index') }}" class="btn btn-sm btn-secondary">
                        <i class="fa fa-arrow-left"></i> Kembali
                    </a>
                </div>
            </div>
            <div class="card-body">
                <form action="{{ route('position.update', $jabatan->id) }}" method="POST">
                    @csrf
                    @method('PATCH')

                    <div class="form-group">
                        <label for="code" class="form-label">Kode Jabatan</label>
                        <input type="text" class="form-control" id="code" name="code"
                            value="{{ $jabatan->code }}" required>
                    </div>

                    <div class="form-group">
                        <label for="name">Nama Jabatan</label>
                        <input type="text" name="name" class="form-control" value="{{ $jabatan->name }}" required>
                    </div>

                    <div class="form-group">
                        <label for="base_salary">Gaji Pokok</label>
                        <input type="number" name="base_salary" class="form-control" value="{{ $jabatan->base_salary }}"
                            required>
                    </div>

                    <button type="submit" class="btn btn-primary">
                        <i class="fa fa-save"></i> Simpan Perubahan
                    </button>
                </form>
            </div>
        </div>
    </div>
@endsection
