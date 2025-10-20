@extends('layouts.app')

@section('title', 'Edit Kategori')

@section('content')
    <div class="container-fluid">
        @include('layouts.alert')

        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Edit Kategori</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('categori.update', $cate->id) }}" method="POST">
                    @csrf
                    @method('patch')

                    <div class="mb-3">
                        <label for="code" class="form-label">Kode Kategori</label>
                        <input type="text" class="form-control" id="code" name="code" value="{{ $cate->code }}"
                            required>
                    </div>

                    <div class="mb-3">
                        <label for="name" class="form-label">Nama Kategori</label>
                        <input type="text" class="form-control" id="name" name="name" value="{{ $cate->name }}"
                            required>
                    </div>

                    <div class="mb-3">
                        <label for="description" class="form-label">Deskripsi</label>
                        <textarea class="form-control" id="description" name="description" rows="3">{{ $cate->description }}</textarea>
                    </div>

                    <button type="submit" class="btn btn-success">Update</button>
                </form>
            </div>
        </div>
    </div>
@endsection
