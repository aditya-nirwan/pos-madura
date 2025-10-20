@extends('layouts.app')

@section('title', 'Edit User')

@section('content')
    <div class="container-fluid">
        @include('layouts.alert')

        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Edit Kasir</h5>
                <a href="{{ url('cashier') }}" class="btn btn-sm btn-secondary">
                    <i class="fa fa-arrow-left"></i> Kembali
                </a>
            </div>

            <div class="card-body">
                <form action="{{ route('users.update', $user->id) }}" method="POST">
                    @csrf
                    @method('PATCH')

                    <div class="mb-3">
                        <label class="col-sm-2 col-form-label">Nama <span class="text-danger">*</span></label>
                        <input type="text" name="name" class="form-control" value="{{ old('name', $user->username) }}"
                            placeholder="Masukkan Nama" required>
                    </div>

                    <div class="mb-3">
                        <label class="col-sm-2 col-form-label">Email</label>
                        <input type="email" name="email" class="form-control" value="{{ old('email', $user->email) }}"
                            placeholder="Masukkan Email">
                    </div>

                    <div class="mb-3">
                        <label class="col-sm-2 col-form-label">Role</label>
                        <div class="col-sm-10">
                            <select name="role" class="form-control" required>
                                <option value="karyawan" {{ $user->role == 'karyawan' ? 'selected' : '' }}>Karyawan
                                </option>
                                <option value="akuntan" {{ old('role') == 'akuntan' ? 'selected' : '' }}>Akuntan
                                </option>
                                <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>Admin</option>
                            </select>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label">Password (kosongkan jika tidak diubah)</label>
                        <input type="password" class="form-control @error('password') is-invalid @enderror" id="password"
                            name="password">
                    </div>

                    <div class="mb-3">
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
