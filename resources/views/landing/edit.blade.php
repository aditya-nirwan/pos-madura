@extends('layouts.app')

@section('title', 'Edit Pengaturan')

@section('content')
    <div class="container-fluid">
        @include('layouts.alert')

        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Edit Pengaturan</h5>
                <a href="{{ url('setting') }}" class="btn btn-sm btn-secondary">
                    <i class="fa fa-arrow-left"></i> Kembali
                </a>
            </div>

            <div class="card-body">
                <form action="{{ route('setting.update', $setting->id) }}" method="POST">
                    @csrf
                    @method('patch')

                    <div class="mb-3">
                        <label for="brand_name" class="form-label">Nama Brand</label>
                        <input type="text" class="form-control @error('brand_name') is-invalid @enderror" id="brand_name"
                            name="brand_name" value="{{ old('brand_name', $setting->brand_name) }}" required>
                        @error('brand_name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="brand_highlight" class="form-label">Highlight Brand</label>
                        <input type="text" class="form-control @error('brand_highlight') is-invalid @enderror"
                            id="brand_highlight" name="brand_highlight"
                            value="{{ old('brand_highlight', $setting->brand_highlight) }}">
                        <small class="text-muted">Contoh: "oo" pada kata <b>Foody</b></small>
                        @error('brand_highlight')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="address" class="form-label">Alamat</label>
                        <input type="text" class="form-control @error('address') is-invalid @enderror" id="address"
                            name="address" value="{{ old('address', $setting->address) }}">
                        @error('address')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control @error('email') is-invalid @enderror" id="email"
                            name="email" value="{{ old('email', $setting->email) }}">
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="facebook" class="form-label">Facebook</label>
                        <input type="text" class="form-control @error('facebook') is-invalid @enderror" id="facebook"
                            name="facebook" value="{{ old('facebook', $setting->facebook) }}">
                        @error('facebook')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="twitter" class="form-label">Twitter</label>
                        <input type="text" class="form-control @error('twitter') is-invalid @enderror" id="twitter"
                            name="twitter" value="{{ old('twitter', $setting->twitter) }}">
                        @error('twitter')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="linkedin" class="form-label">LinkedIn</label>
                        <input type="text" class="form-control @error('linkedin') is-invalid @enderror" id="linkedin"
                            name="linkedin" value="{{ old('linkedin', $setting->linkedin) }}">
                        @error('linkedin')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="instagram" class="form-label">Instagram</label>
                        <input type="text" class="form-control @error('instagram') is-invalid @enderror" id="instagram"
                            name="instagram" value="{{ old('instagram', $setting->instagram) }}">
                        @error('instagram')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <button type="submit" class="btn btn-primary">Update</button>
                </form>
            </div>
        </div>
    </div>
@endsection
