@extends('layouts.app')

@section('title', 'Data Jabatan')

@section('content')

    <div class="container-fluid">
        <div class="col-md-12">

            @include('layouts.alert')

            <div class="d-flex justify-content-between align-items-center mb-3">
                <h4>Daftar Jabatan</h4>
                <a href="{{ url('jabatan/create') }}" class="btn btn-primary">Tambah Jabatan</a>
            </div>

            <div class="card">
                <div class="card-body table-responsive">
                    <table class="table table-striped table-hover">
                        <thead class="">
                            <tr>
                                <th>#</th>
                                <th>Kode Jabatan</th>
                                <th>Nama Jabatan</th>
                                <th>Gaji Pokok</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($jabatans as $jabatan)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $jabatan->code }}</td>
                                    <td>{{ $jabatan->name }}</td>
                                    <td>Rp {{ number_format($jabatan->base_salary, 0, ',', '.') }}</td>
                                    <td>
                                        <a href="{{ route('position.edit', $jabatan->id) }}" class="btn btn-sm btn-warning"
                                            title="Edit">
                                            <i class="fa fa-edit"></i>
                                        </a>
                                        <form action="{{ route('position.destroy', $jabatan->id) }}" method="POST"
                                            style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-sm btn-danger"
                                                onclick="return confirm('Yakin ingin menghapus jabatan ini?')">
                                                <i class="fa fa-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center">Data jabatan belum tersedia.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
