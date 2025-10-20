@extends('layouts.app')

@section('title', 'Rekap Gaji')

@section('content')
    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h4>Rekap Gaji Bulan {{ $month }}</h4>
            <form method="GET" action="{{ route('payrolls.rekap') }}">
                <input type="month" name="month" value="{{ $month }}" class="form-control form-control-sm"
                    style="width:auto;display:inline-block;">
                <button type="submit" class="btn btn-sm btn-primary">Filter</button>
            </form>
        </div>

        <div class="card">
            <div class="card-body table-responsive">
                <table class="table table-bordered table-striped">
                    <thead class="thead">
                        <tr>
                            <th>Nama</th>
                            <th>Jabatan</th>
                            <th>Gaji Pokok</th>
                            <th>Tunjangan</th>
                            <th>Potongan Absensi</th>
                            <th>Potongan Lain</th>
                            <th>Gaji Kotor</th>
                            <th>PPh 21</th>
                            <th>Take Home Pay</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($payrolls as $p)
                            <tr>
                                <td>{{ $p->employee->name }}</td>
                                <td>{{ $p->employee->position->name }}</td>
                                <td>{{ number_format($p->employee->position->base_salary, 0, ',', '.') }}</td>
                                <td>{{ number_format($p->addition_salary, 0, ',', '.') }}</td>
                                <td>{{ number_format($p->attendance_deduction, 0, ',', '.') }}</td>
                                <td>{{ number_format($p->deduction_salary, 0, ',', '.') }}</td>
                                <td>{{ number_format($p->gross_salary, 0, ',', '.') }}</td>
                                <td>{{ number_format($p->pph_21_tax, 0, ',', '.') }}</td>
                                <td><strong>{{ number_format($p->take_home_pay, 0, ',', '.') }}</strong></td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" class="text-center">Belum ada data penggajian di bulan ini</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
