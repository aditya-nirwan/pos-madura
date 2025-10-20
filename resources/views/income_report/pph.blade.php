@extends('layouts.app')

@section('title', 'Laporan PPh Final')

@section('content')
    <div class="container">

        {{-- Card Header & Filter --}}
        <div class="card shadow-sm border-0 mb-3">
            <div class="card-body d-flex justify-content-between align-items-center flex-wrap">
                <h3 class="fw-bold mb-2 mb-md-0">
                    Laporan PPh Final {{ $year }}
                </h3>

                <div class="d-flex gap-2">
                    {{-- Form filter tahun --}}
                    <form method="GET" action="{{ route('laporan.pph') }}" class="d-flex gap-2">
                        <input type="number" name="year" id="year" class="form-control form-control-sm"
                            value="{{ $year }}" min="2000" max="{{ date('Y') }}" style="width:120px">
                        <button type="submit" class="btn btn-primary btn-sm">Filter</button>
                    </form>

                    {{-- Tombol download PDF --}}
                    <a id="download-pdf" href="{{ route('laporan.pph.pdf', ['year' => $year]) }}"
                        class="btn btn-danger btn-sm">
                        <i class="fas fa-file-pdf"></i> Download PDF
                    </a>

                </div>

            </div>
        </div>

        {{-- Card Tabel Laporan --}}
        <div class="card shadow-sm border-0">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered align-middle mb-0">
                        <thead>
                            <tr class="text-center">
                                <th>Bulan</th>
                                <th>Total Income</th>
                                <th>Total PPN</th>
                                <th>Omzet</th>
                                <th>PPh Final (0,5%)</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($revenues as $rev)
                                <tr>
                                    <td class="fw-bold text-center">
                                        {{ \Carbon\Carbon::create()->month($rev->bulan)->translatedFormat('F') }}
                                    </td>
                                    <td>Rp {{ number_format($rev->total_income, 0, ',', '.') }}</td>
                                    <td>Rp {{ number_format($rev->total_tax, 0, ',', '.') }}</td>
                                    <td>Rp {{ number_format($rev->omzet, 0, ',', '.') }}</td>
                                    <td class="fw-bold text-success">
                                        Rp {{ number_format($rev->pph, 0, ',', '.') }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center text-muted">Tidak ada data laporan tahun ini</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
@endsection
