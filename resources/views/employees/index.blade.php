@extends('layouts.app')

@section('title', 'Data Karyawan')

@section('content')
    <div class="container-fluid">
        <div class="col-md-12">

            @include('layouts.alert')

            <div class="d-flex justify-content-between align-items-center mb-3">
                <h4>Daftar Karyawan</h4>
                <a href="{{ url('karyawan/create') }}" class="btn btn-primary">Tambah Karyawan</a>
            </div>

            <div class="card">
                <div class="card-body table-responsive">
                    <table class="table table-striped table-hover">
                        <thead class="">
                            <tr>
                                <th>NIK</th>
                                <th>Nama</th>
                                <th>Jabatan</th>
                                <th>Gender</th>
                                <th>Tanggal Lahir</th>
                                <th>No HP</th>
                                <th>Alamat</th>
                                <th>Status PTKP</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($employees as $employee)
                                <tr>
                                    <td>{{ $employee->employee_code }}</td>
                                    <td>{{ $employee->name }}</td>
                                    <td>{{ optional($employee->position)->name ?? '-' }}</td>
                                    <td>{{ $employee->gender == 'M' ? 'Laki-laki' : 'Perempuan' }}</td>
                                    <td>
                                        @if ($employee->birth_date)
                                            {{ \Carbon\Carbon::parse($employee->birth_date)->format('d-m-Y') }}
                                        @else
                                            -
                                        @endif
                                    </td>
                                    <td>{{ $employee->phone_number ?? '-' }}</td>
                                    <td>{{ $employee->address ?? '-' }}</td>
                                    <td>{{ $employee->ptkp_status ?? '-' }}</td>
                                    <td>
                                        <a href="{{ route('employees.edit', $employee->id) }}"
                                            class="btn btn-sm btn-warning">
                                            <i class="fa fa-edit"></i>
                                        </a>
                                        <form action="{{ route('employees.destroy', $employee->id) }}" method="POST"
                                            style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-sm btn-danger"
                                                onclick="return confirm('Hapus Data Ini?')">
                                                <i class="fa fa-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="9" class="text-center">No employees found.</td>
                                </tr>
                            @endforelse

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
