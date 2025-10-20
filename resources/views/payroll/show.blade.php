@extends('layouts.app')

@section('title', 'Gaji Karyawan')

@section('content')
    <div class="container-fluid">
        <div class="col-md-12">

            @include('layouts.alert')

            <h4 class="mb-3">Piih Karyawan</h4>
            <div class="card shadow-sm">
                <div class="card-body">
                    <form action="{{ route('payrolls.create') }}" method="GET">
                        <div class="form-group mb-3">
                            <label for="employee_id">Pilih Karyawan</label>
                            <select name="employee_id" id="employee_id" class="form-control select2" required>
                                <option value="">-- Pilih Karyawan --</option>
                                @foreach ($employees as $emp)
                                    <option value="{{ $emp->id }}">
                                        {{ $emp->employee_code }} - {{ $emp->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group mb-3">
                            <label for="month">Pilih Bulan</label>
                            <input type="month" name="month" class="form-control" value="{{ date('Y-m') }}" required>
                        </div>

                        <button type="submit" class="btn btn-primary">Lanjut</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    {{-- jQuery dulu --}}
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    {{-- Select2 CSS & JS --}}
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script>
        $(document).ready(function() {
            $('#employee_id').select2({
                placeholder: "-- Pilih Karyawan --",
                width: '100%' // biar selec2 melebar sesuai container
            });
        });
    </script>
@endsection
