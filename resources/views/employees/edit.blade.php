@extends('layouts.app')

@section('title', 'Edit Karyawan')

@section('content')
    <div class="container my-4">
        <div class="card">
            <div class="card-header">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5>Edit Data {{ $employee->name }}</h5>
                    <a href="{{ route('employees.index') }}" class="btn btn-sm btn-secondary">
                        <i class="fa fa-arrow-left"></i> Kembali
                    </a>
                </div>
            </div>

            <div class="card-body">
                <form action="{{ route('employees.update', $employee->id) }}" method="POST">
                    @csrf
                    @method('PATCH')

                    <div class="form-group">
                        <label for="employee_code">Kode Karyawan</label>
                        <input type="text" name="employee_code" class="form-control"
                            value="{{ $employee->employee_code }}" required>
                    </div>

                    <div class="form-group">
                        <label for="name">Nama Karyawan</label>
                        <input type="text" name="name" class="form-control" value="{{ $employee->name }}" required>
                    </div>

                    <div class="form-group">
                        <label for="position_id">Jabatan</label>
                        <select name="position_id" class="form-control" required>
                            <option value="">-- Pilih Jabatan --</option>
                            @foreach ($positions as $position)
                                <option value="{{ $position->id }}"
                                    {{ $employee->position_id == $position->id ? 'selected' : '' }}>
                                    {{ $position->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="gender">Jenis Kelamin</label>
                        <select name="gender" class="form-control" required>
                            <option value="">-- Pilih Gender --</option>
                            <option value="M" {{ $employee->gender == 'M' ? 'selected' : '' }}>Laki-laki</option>
                            <option value="F" {{ $employee->gender == 'F' ? 'selected' : '' }}>Perempuan</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="birth_date">Tanggal Lahir</label>
                        <input type="date" name="birth_date" class="form-control" value="{{ $employee->birth_date }}"
                            required>
                    </div>

                    <div class="form-group">
                        <label for="phone_number">No HP</label>
                        <input type="text" name="phone_number" class="form-control"
                            value="{{ $employee->phone_number }}" required>
                    </div>

                    <div class="form-group">
                        <label for="address">Alamat</label>
                        <textarea name="address" class="form-control" rows="3" required>{{ $employee->address }}</textarea>
                    </div>

                    <div class="form-group">
                        <label for="ptkp_status">Status PTKP</label>
                        <select name="ptkp_status" class="form-control" required>
                            <option value="">-- Pilih Status PTKP --</option>
                            <option value="TK/0" {{ $employee->ptkp_status == 'TK/0' ? 'selected' : '' }}>TK/0
                                (Rp54.000.000)</option>
                            <option value="TK/1" {{ $employee->ptkp_status == 'TK/1' ? 'selected' : '' }}>TK/1
                                (Rp58.500.000)</option>
                            <option value="TK/2" {{ $employee->ptkp_status == 'TK/2' ? 'selected' : '' }}>TK/2
                                (Rp63.000.000)</option>
                            <option value="TK/3" {{ $employee->ptkp_status == 'TK/3' ? 'selected' : '' }}>TK/3
                                (Rp67.500.000)</option>
                            <option value="K/0" {{ $employee->ptkp_status == 'K/0' ? 'selected' : '' }}>K/0
                                (Rp58.500.000)</option>
                            <option value="K/1" {{ $employee->ptkp_status == 'K/1' ? 'selected' : '' }}>K/1
                                (Rp63.000.000)</option>
                            <option value="K/2" {{ $employee->ptkp_status == 'K/2' ? 'selected' : '' }}>K/2
                                (Rp67.500.000)</option>
                            <option value="K/3" {{ $employee->ptkp_status == 'K/3' ? 'selected' : '' }}>K/3
                                (Rp72.000.000)</option>
                        </select>
                    </div>

                    <button type="submit" class="btn btn-primary">
                        <i class="fa fa-save"></i> Simpan Perubahan
                    </button>
                    <a href="{{ route('employees.index') }}" class="btn btn-secondary">Batal</a>
                </form>


            </div>
        </div>
    </div>
@endsection
