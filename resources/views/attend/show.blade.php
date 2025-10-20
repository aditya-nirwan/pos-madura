@extends('layouts.app')

@section('title', 'Absensi')

@section('content')

    <div class="container-fluid">
        <div class="col-md-12">

            @include('layouts.alert')

            <div class="card shadow-lg border-0 rounded-3">
                <div class="card-header bg-success text-white d-flex justify-content-between align-items-center">
                    <h4 class="mb-0"> Absensi Karyawan</h4>
                </div>

                <form action="{{ route('attend.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="card-body">

                        <div class="form-group mb-4">
                            <label for="date" class="fw-semibold">Tanggal Absensi</label>
                            <input type="date" id="date" name="date"
                                class="form-control w-auto d-inline-block ms-2" value="{{ $date }}" required>
                        </div>

                        <div class="table-responsive">
                            <table class="table table-bordered table-hover align-middle shadow-sm rounded">
                                <thead class="text-center">
                                    <tr>
                                        <th style="width: 100px;">NIK</th>
                                        <th style="width: 200px;">Nama</th>
                                        <th style="width: 180px;">Status Kehadiran</th>
                                        <th style="width: 200px;">Upload / Lihat Surat</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($employees as $index => $employee)
                                        @php
                                            $attend = $attendances[$employee->id] ?? null;
                                        @endphp
                                        <tr>
                                            <td class="text-center fw-semibold">{{ $employee->employee_code }}</td>
                                            <td>{{ $employee->name }}</td>

                                            <td>
                                                <input type="hidden" name="attendances[{{ $index }}][employee_id]"
                                                    value="{{ $employee->id }}">
                                                <input type="hidden" name="attendances[{{ $index }}][date]"
                                                    class="attendance-date" value="{{ $date }}">

                                                <select name="attendances[{{ $index }}][status]"
                                                    class="form-select status-select" required>
                                                    <option value="">-- Pilih Status --</option>
                                                    <option value="present"
                                                        {{ $attend && $attend->status == 'present' ? 'selected' : '' }}>
                                                        Masuk</option>
                                                    <option value="permission"
                                                        {{ $attend && $attend->status == 'permission' ? 'selected' : '' }}>
                                                        Izin</option>
                                                    <option value="sick"
                                                        {{ $attend && $attend->status == 'sick' ? 'selected' : '' }}>
                                                        Sakit</option>
                                                    <option value="absent"
                                                        {{ $attend && $attend->status == 'absent' ? 'selected' : '' }}>
                                                        Tanpa Izin</option>
                                                </select>
                                            </td>

                                            <td class="text-center">
                                                @if ($attend && ($attend->status == 'permission' || $attend->status == 'sick') && $attend->proof_image)
                                                    <a href="{{ asset('attendance_letters/' . $attend->proof_image) }}"
                                                        target="_blank">
                                                        <img src="{{ asset('attendance_letters/' . $attend->proof_image) }}"
                                                            alt="Surat" class="img-thumbnail mb-2"
                                                            style="width: 80px; height: 80px; object-fit: cover;">
                                                    </a>
                                                @endif

                                                <div>
                                                    <input type="file"
                                                        name="attendances[{{ $index }}][proof_image]"
                                                        class="form-control form-control-sm upload-proof mx-auto"
                                                        accept="image/*" style="display: none; max-width: 160px;">
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                    </div>

                    <div class="card-footer d-flex justify-content-end bg-white">
                        <button type="submit" class="btn btn-lg btn-success shadow-sm">
                            Simpan Absensi
                        </button>
                    </div>
                </form>
            </div>

        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $('#date').on('change', function() {
            let selectedDate = $(this).val();
            $('.attendance-date').val(selectedDate);
            window.location.href = "{{ route('attend') }}" + "?date=" + selectedDate;
        });

        $(document).ready(function() {
            function toggleUpload(selectElem) {
                let row = selectElem.closest('tr');
                let val = selectElem.val();
                if (val === 'permission' || val === 'sick') {
                    row.find('.upload-proof').show();
                } else {
                    row.find('.upload-proof').hide();
                }
            }

            $('.status-select').each(function() {
                toggleUpload($(this));
            });

            $('.status-select').on('change', function() {
                toggleUpload($(this));
            });
        });
    </script>
@endsection
