@extends('layouts.app')

@section('title', 'Rekap Tunjangan')

@section('content')
    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h4>Rekap Tunjangan Bulan {{ $month }}</h4>
            <form method="GET" action="{{ route('payrolls.tunjangan') }}">
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
                            <th>Jenis Tunjangan</th>
                            <th>Jumlah</th>
                            <th>Tanggal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($allowances as $a)
                            <tr>
                                <td>{{ $a->employee_name }}</td>
                                <td>{{ $a->allowance_name }}</td>
                                <td>Rp {{ number_format($a->amount, 0, ',', '.') }}</td>
                                <td>{{ \Carbon\Carbon::parse($a->payroll_month . '-01')->format('F Y') }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center">Belum ada data tunjangan bulan ini</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
