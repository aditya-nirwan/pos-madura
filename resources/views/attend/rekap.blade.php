@extends('layouts.app')

@section('title', 'Rekap Absensi')

@section('content')
    <div class="container my-4">
        <h2 class="mb-4">Rekap Absensi Karyawan</h2>

        {{-- Card Filter Bulan --}}
        <div class="card shadow-sm mb-4">
            <div class="card-body">
                <form method="GET" id="filter-form" class="form-inline">
                    <label for="month" class="mr-2"><strong>Pilih Bulan:</strong></label>
                    <input type="month" id="month" name="month" value="{{ $month }}" class="form-control">
                </form>
            </div>
        </div>

        {{-- Card Rekap --}}
        <div class="card shadow-sm">
            <div class="card-body">
                <h5 class="card-title mb-3">Hasil Rekap {{ \Carbon\Carbon::parse($month . '-01')->translatedFormat('F Y') }}
                </h5>
                <div class="table-responsive">
                    <table class="table table-bordered table-striped mb-0">
                        <thead class="">
                            <tr>
                                <th>Nama</th>
                                <th>Hadir</th>
                                <th>Izin</th>
                                <th>Sakit</th>
                                <th>Tanpa Izin</th>
                                <th>Total Hari Absen</th>
                                <th>Persentase Kehadiran</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($rekap as $data)
                                @php
                                    $persen =
                                        $data['total_days'] > 0
                                            ? round(($data['present'] / $data['total_days']) * 100, 2)
                                            : 0;
                                @endphp
                                <tr>
                                    <td>{{ $data['employee']->name }}</td>
                                    <td class="text-center">{{ $data['present'] }}</td>
                                    <td class="text-center">{{ $data['permission'] }}</td>
                                    <td class="text-center">{{ $data['sick'] }}</td>
                                    <td class="text-center">{{ $data['absent'] }}</td>
                                    <td class="text-center">{{ $data['total_days'] }}</td>
                                    <td class="text-center font-weight-bold">
                                        {{ $persen }}%
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    {{-- Script auto submit --}}
    <script>
        document.getElementById('month').addEventListener('change', function() {
            document.getElementById('filter-form').submit();
        });
    </script>
@endsection
