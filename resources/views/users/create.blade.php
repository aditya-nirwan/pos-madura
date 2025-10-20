@extends('layouts.app')

@section('title', 'Tambah User')

@section('content')
    <div class="row">
        <div class="col-md-12">
            @include('layouts.alert')

            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5>Tambah User</h5>
                    <a href="{{ url('users') }}" class="btn btn-sm btn-secondary">
                        <i class="fa fa-arrow-left"></i> Kembali
                    </a>
                </div>

                <div class="card-body">
                    <form action="{{ route('users.store') }}" method="POST">
                        @csrf

                        {{-- Nama --}}
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Username <span class="text-danger">*</span></label>
                            <div class="col-sm-10">
                                <input type="text" name="nama" class="form-control" placeholder="Masukkan Username"
                                    value="{{ old('nama') }}" required>
                            </div>
                        </div>

                        {{-- Email --}}
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Email <span class="text-danger">*</span></label>
                            <div class="col-sm-10">
                                <input type="email" name="email" class="form-control" placeholder="Masukkan email"
                                    value="{{ old('email') }}" required>
                            </div>
                        </div>

                        {{-- Role --}}
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Role <span class="text-danger">*</span></label>
                            <div class="col-sm-10">
                                <select name="role" class="form-control" required>
                                    <option value="" disabled selected>Pilih role</option>
                                    <option value="karyawan" {{ old('role') == 'karyawan' ? 'selected' : '' }}>Karyawan
                                    </option>
                                    <option value="akuntan" {{ old('role') == 'akuntan' ? 'selected' : '' }}>Akuntan
                                    </option>
                                    <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                                </select>
                            </div>
                        </div>

                        {{-- Password --}}
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Password <span class="text-danger">*</span></label>
                            <div class="col-sm-10">
                                <input type="password" name="password" class="form-control" placeholder="Masukkan password"
                                    required>
                            </div>
                        </div>

                        {{-- Tombol Submit --}}
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
