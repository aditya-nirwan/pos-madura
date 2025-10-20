@extends('layouts.app')

@section('title', 'Tambah Jabatan')

@section('content')
    <div class="row">
        <div class="col-md-12">

            @include('layouts.alert')

            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5>Tambah Jabatan</h5>
                    <a href="{{ url('jabatan') }}" class="btn btn-sm btn-secondary">
                        <i class="fa fa-arrow-left"></i> Kembali
                    </a>
                </div>

                <div class="card-block">
                    <form action="{{ route('position.store') }}" method="POST">
                        @csrf
                        <div class="form-group row">
                            <label for="code" class="col-sm-2 col-form-label">Kode Jabatan<span
                                    class="text-danger">*</span></label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="code" name="code"
                                    placeholder="Kode Jabatan" value="{{ old('code') }}" required>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Nama Jabatan<span class="text-danger">*</span></label>
                            <div class="col-sm-10">
                                <input type="text" name="name" class="form-control" placeholder="Nama Jabatan"
                                    value="{{ old('name') }}" required>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Gaji Pokok <span class="text-danger">*</span></label>
                            <div class="col-sm-10">
                                <input type="number" name="base_salary" class="form-control" value="old('base_salary')"
                                    placeholder="Masukkan Nominal">
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-sm-10 offset-sm-2">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fa fa-save"></i> Simpan
                                </button>
                            </div>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
