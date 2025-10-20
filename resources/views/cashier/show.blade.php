@extends('layouts.app')

@section('title', 'User Kasir')

@section('content')
    <div class="container-fluid">
        <div class="col-md-12">

            @include('layouts.alert')

            <div class="d-flex justify-content-between align-items-center mb-3">
                <h4>Daftar Kasir</h4>
                <a href="{{ url('cashier/create') }}" class="btn btn-primary">Tambah Kasir</a>
            </div>

            <div class="card">
                <div class="card-body table-responsive">
                    <table class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Nama</th>
                                <th>Username</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($show as $key => $cat)
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td>{{ $cat->name }}</td>
                                    <td>{{ $cat->username }}</td>
                                    <td>
                                        <a href="{{ route('cashier.edit', $cat->id) }}"
                                            class="btn btn-sm btn-warning">Edit</a>
                                        <form action="{{ route('cashier.delete', $cat->id) }}" method="POST"
                                            class="d-inline" onsubmit="return confirm('Hapus data kasir ini?')">
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
