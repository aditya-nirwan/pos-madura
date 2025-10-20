@extends('layouts.app')

@section('title', 'Tambah Karyawan')

@section('content')
    <div class="row">
        <div class="col-md-12">

            @include('layouts.alert')

            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5>Tambah Karyawan</h5>
                    <a href="{{ url('karyawan') }}" class="btn btn-sm btn-secondary">
                        <i class="fa fa-arrow-left"></i> Kembali
                    </a>
                </div>

                <div class="card-block">
                    <form action="{{ route('employees.store') }}" method="POST">
                        @csrf

                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">NIK Karyawan<span class="text-danger">*</span></label>
                            <div class="col-sm-10">
                                <input type="text" name="employee_code" class="form-control"
                                    placeholder="Nomor Induk Karyawan" value="{{ old('employee_code') }}" required>
                                @error('employee_code')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Nama <span class="text-danger">*</span></label>
                            <div class="col-sm-10">
                                <input type="text" name="name" class="form-control" placeholder="Nama"
                                    value="{{ old('name') }}" required>
                                @error('name')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Jabatan <span class="text-danger">*</span></label>
                            <div class="col-sm-10">
                                <select name="position_id" class="form-control" required>
                                    <option value="">-- Pilih Jabatan --</option>
                                    @foreach ($positions as $position)
                                        <option value="{{ $position->id }}"
                                            {{ old('position_id') == $position->id ? 'selected' : '' }}>
                                            {{ $position->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('position_id')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Status PTKP</label>
                            <div class="col-sm-10">
                                <select name="ptkp_status" class="form-control" required>
                                    <option value="TK/0" {{ old('ptkp_status') == 'TK/0' ? 'selected' : '' }}>TK/0 -
                                        Tidak Kawin, 0 Tanggungan</option>
                                    <option value="TK/1" {{ old('ptkp_status') == 'TK/0' ? 'selected' : '' }}>TK/0 -
                                        Tidak Kawin, 1 Tanggungan</option>
                                    <option value="TK/2" {{ old('ptkp_status') == 'TK/0' ? 'selected' : '' }}>TK/0 -
                                        Tidak Kawin, 2 Tanggungan</option>
                                    <option value="TK/3" {{ old('ptkp_status') == 'TK/0' ? 'selected' : '' }}>TK/0 -
                                        Tidak Kawin, 3 Tanggungan</option>
                                    <option value="K/0" {{ old('ptkp_status') == 'K/0' ? 'selected' : '' }}>K/0 - Kawin,
                                        0 Tanggungan</option>
                                    <option value="K/1" {{ old('ptkp_status') == 'K/1' ? 'selected' : '' }}>K/1 - Kawin,
                                        1 Tanggungan</option>
                                    <option value="K/2" {{ old('ptkp_status') == 'K/2' ? 'selected' : '' }}>K/2 - Kawin,
                                        2 Tanggungan</option>
                                    <option value="K/3" {{ old('ptkp_status') == 'K/3' ? 'selected' : '' }}>K/3 - Kawin,
                                        3 Tanggungan</option>
                                </select>
                                @error('ptkp_status')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>


                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Nomor Hp</label>
                            <div class="col-sm-10">
                                <input type="text" name="phone_number" class="form-control" placeholder="08xxxxxxxxxx"
                                    value="{{ old('phone_number') }}">
                                @error('phone_number')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Jenis Kelamin</label>
                            <div class="col-sm-10">
                                <select name="gender" class="form-control">
                                    <option value="">-- Pilih Jenis Kelamin --</option>
                                    <option value="M" {{ old('gender') == 'M' ? 'selected' : '' }}>Laki-laki</option>
                                    <option value="F" {{ old('gender') == 'F' ? 'selected' : '' }}>Perempuan</option>
                                </select>
                                @error('gender')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Alamat</label>
                            <div class="col-sm-10">
                                <textarea name="address" class="form-control" rows="2" placeholder="Alamat lengkap">{{ old('address') }}</textarea>
                                @error('address')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Tanggal Lahir</label>
                            <div class="col-sm-10">
                                <input type="date" name="birth_date" class="form-control date"
                                    value="{{ old('birth_date') }}" placeholder="Masukkan tanggal lahir">
                                @error('birth_date')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-sm-10 offset-sm-2">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fa fa-save"></i> Save
                                </button>
                                <a href="{{ route('employees.index') }}" class="btn btn-danger ml-2">Cancel</a>
                            </div>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
@endsection
