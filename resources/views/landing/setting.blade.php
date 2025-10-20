@extends('layouts.app')

@section('title', 'Seeting Title')

@section('content')
    <div class="container-fluid">
        <div class="col-md-12">

            @include('layouts.alert')

            <div class="d-flex justify-content-between align-items-center mb-3">
                <h4>Daftar isi title</h4>
            </div>

            <div class="card">
                <div class="card-body table-responsive">
                    <table class="table table-striped table-hover">
                        <thead>

                            <th>Nama Brand</th>

                            <th>Highlight</th>

                            <th>Alamat</th>

                            <th>Email</th>

                            <th>Facebook</th>

                            <th>Twitter</th>

                            <th>LinkedIn</th>

                            <th>Instagram</th>
                            <th>Aksi</th>
                        </thead>
                        <tbody>
                            @forelse($show as $key => $cat)
                                <tr>
                                    <td>{{ $cat->brand_name }}</td>
                                    <td>{{ $cat->brand_highlight ?? '-' }}</td>
                                    <td>{{ $cat->address ?? '-' }}</td>
                                    <td>{{ $cat->email ?? '-' }}</td>
                                    <td>{{ $cat->facebook ?? '-' }}</td>
                                    <td>{{ $cat->twitter ?? '-' }}</td>
                                    <td>{{ $cat->linkedin ?? '-' }}</td>
                                    <td>{{ $cat->instagram ?? '-' }}</td>
                                    <td>
                                        <a href="{{ route('setting.edit', $cat->id) }}"
                                            class="btn btn-sm btn-warning">Edit</a>
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
