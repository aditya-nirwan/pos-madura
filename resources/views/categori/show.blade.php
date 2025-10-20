@extends('layouts.app')

@section('title', 'Kategori Barang')

@section('content')
    <div class="container-fluid">
        <div class="col-md-12">

            @include('layouts.alert')

            <div class="d-flex justify-content-between align-items-center mb-3">
                <h4>Daftar Kategori</h4>
                <a href="{{ url('categori/create') }}" class="btn btn-primary">Tambah Kategori</a>
            </div>

            <div class="card">
                <div class="card-body table-responsive">
                    <table class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Kode</th>
                                <th>Nama Kategori</th>
                                <th>Deskripsi</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($show as $key => $cat)
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td>{{ $cat->code }}</td>
                                    <td>{{ $cat->name }}</td>
                                    <td>{{ $cat->description ?? '-' }}</td>
                                    <td>
                                        <a href="{{ route('categori.edit', $cat->id) }}"
                                            class="btn btn-sm btn-warning">Edit</a>
                                        <form action="{{ route('categori.delete', $cat->id) }}" method="POST"
                                            class="d-inline" onsubmit="return confirm('Hapus kategori ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-sm btn-danger">Hapus</button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center">Belum ada data kategori.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
