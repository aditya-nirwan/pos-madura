@extends('layouts.app')

@section('title', 'Form Gaji Karyawan')

@section('content')
    <div class="container-fluid">
        <div class="col-md-12">
            @include('layouts.alert')

            <form action="{{ route('payrolls.store') }}" method="POST" id="payrollForm">
                @csrf
                <input type="hidden" name="employee_id" value="{{ $employee->id }}">
                <input type="hidden" name="month" value="{{ $month }}">
                <input type="hidden" id="ptkp_status" value="{{ $employee->ptkp_status }}">
                <!-- Card: Data Karyawan + Absensi + Detail Gaji -->
                <div class="card shadow-sm mb-4">
                    <div class="card-header bg-info text-white d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Form Gaji Karyawan</h5>
                        <a href="{{ route('payroll.show') }}" class="btn btn-sm btn-light">
                            <i class="fa fa-arrow-left"></i> Kembali
                        </a>
                    </div>

                    <div class="card-body">
                        <!-- Data Karyawan -->
                        <h6 class="fw-bold mb-3">Data Karyawan</h6>
                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label">Nama</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" value="{{ $employee->name }}" readonly>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label">Jabatan</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" value="{{ $employee->position->name }}" readonly>
                            </div>
                        </div>
                        <div class="row mb-4">
                            <label class="col-sm-2 col-form-label">Bulan</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" value="{{ $month }}" readonly>
                            </div>
                        </div>

                        <hr>

                        <!-- Data Absensi -->
                        <h6 class="fw-bold mb-3">Data Absensi</h6>
                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label">Izin</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" value="{{ $izin }} hari" readonly>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label">Tanpa Izin</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" value="{{ $tanpaIzin }} hari" readonly>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label">Sakit</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" value="{{ $sakit }} hari" readonly>
                            </div>
                        </div>
                        <div class="row mb-4">
                            <label class="col-sm-2 col-form-label">Potongan Absensi</label>
                            <div class="col-sm-10">
                                <input type="number" class="form-control" name="attendance_deduction"
                                    value="{{ $potonganAbsensi }}" readonly>
                            </div>
                        </div>

                        <hr>

                        <!-- Detail Gaji -->
                        <h6 class="fw-bold mb-3">Detail Gaji</h6>
                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label">Gaji Pokok</label>
                            <div class="col-sm-10">
                                <input type="number" id="base_salary" class="form-control"
                                    value="{{ $employee->position->base_salary }}" readonly>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label">Tunjangan</label>
                            <div class="col-sm-10">
                                <input type="number" id="addition_salary" name="addition_salary" class="form-control"
                                    value="0" oninput="calculatePayroll()">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label">Potongan Lain</label>
                            <div class="col-sm-10">
                                <input type="number" id="deduction_salary" name="deduction_salary" class="form-control"
                                    value="0" oninput="calculatePayroll()">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label">Gaji Kotor</label>
                            <div class="col-sm-10">
                                <input type="number" id="gross_salary" name="gross_salary" class="form-control"
                                    value="0" readonly>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label">PPH 21</label>
                            <div class="col-sm-10">
                                <input type="number" id="pph_21_tax" name="pph_21_tax" class="form-control"
                                    value="0" readonly>
                            </div>
                        </div>
                        <div class="row mb-0">
                            <label class="col-sm-2 col-form-label">Take Home Pay</label>
                            <div class="col-sm-10">
                                <input type="number" id="take_home_pay" name="take_home_pay" class="form-control"
                                    value="0" readonly>
                            </div>
                        </div>
                    </div>
                </div>


                <!-- Row: Card Tunjangan & Potongan -->
                <div class="row">
                    <!-- Card Tunjangan -->
                    <div class="col-md-6">
                        <div class="card shadow-sm mb-4">
                            <div class="card-header bg-primary text-white">
                                <h6 class="mb-0">Detail Tunjangan</h6>
                            </div>
                            <div class="card-body">
                                <table class="table no-datatable table-bordered" id="allowancesTable">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Nama Tunjangan</th>
                                            <th class="text-end">Nominal</th>
                                            <th class="text-center" style="width: 50px;">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody></tbody>
                                </table>
                                <button type="button" class="btn btn-sm btn-primary" onclick="addAllowanceRow()">
                                    + Tambah Tunjangan
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Card Potongan -->
                    <div class="col-md-6">
                        <div class="card shadow-sm mb-4">
                            <div class="card-header bg-danger text-white">
                                <h6 class="mb-0">Detail Potongan</h6>
                            </div>
                            <div class="card-body">
                                <table class="table no-datatable table-bordered" id="deductionsTable">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Nama Potongan</th>
                                            <th class="text-end">Nominal</th>
                                            <th class="text-center" style="width: 50px;">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody></tbody>
                                </table>
                                <button type="button" class="btn btn-sm btn-danger" onclick="addDeductionRow()">
                                    + Tambah Potongan
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Card: Submit -->
                <div class="text-end mb-4">
                    <button type="submit" class="btn btn-success">
                        <i class="fa fa-save"></i> Simpan Payroll
                    </button>
                </div>
            </form>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        function calculatePayroll() {
            // Ambil nilai input utama
            let baseSalary = parseInt(document.getElementById('base_salary').value) || 0;
            let potonganAbsensi = parseInt({{ $potonganAbsensi }}) || 0;

            // Reset total allowance dan deduction
            let allowanceTotal = 0;
            let deductionTotal = 0;

            // Hitung ulang total tunjangan dari tabel
            document.querySelectorAll('.allowance-amount').forEach(el => {
                allowanceTotal += parseInt(el.value) || 0;
            });

            // Hitung ulang total potongan dari tabel
            document.querySelectorAll('.deduction-amount').forEach(el => {
                deductionTotal += parseInt(el.value) || 0;
            });

            // **Sinkronisasi nilai input atas**
            document.getElementById('addition_salary').value = allowanceTotal;
            document.getElementById('deduction_salary').value = deductionTotal;

            // Hitung gaji kotor
            let grossSalary = baseSalary + allowanceTotal - deductionTotal - potonganAbsensi;

            // Ambil status PTKP
            let ptkpStatus = document.getElementById('ptkp_status').value;
            let ptkpMap = {
                'TK/0': 54000000,
                'TK/1': 58500000,
                'TK/2': 63000000,
                'TK/3': 67500000,
                'K/0': 58500000,
                'K/1': 63000000,
                'K/2': 67500000,
                'K/3': 72000000,
            };

            let ptkpTahun = ptkpMap[ptkpStatus] || 54000000;
            let ptkpBulan = ptkpTahun / 12;

            // Hitung PPh 21
            let pph21 = 0;
            if (grossSalary > ptkpBulan) {
                let pkpBulan = grossSalary - ptkpBulan;
                pph21 = Math.floor(pkpBulan * 0.05);
            }

            // Hitung Take Home Pay
            let takeHomePay = grossSalary - pph21;

            // Tampilkan hasil ke input
            document.getElementById('gross_salary').value = grossSalary;
            document.getElementById('pph_21_tax').value = pph21;
            document.getElementById('take_home_pay').value = takeHomePay;
        }

        // Jalankan pertama kali saat halaman dimuat



        function addAllowanceRow() {
            let row = `
            <tr>
                <td><input type="text" name="allowances[name][]" class="form-control"></td>
                <td><input type="number" name="allowances[amount][]" class="form-control allowance-amount" oninput="calculatePayroll()"></td>
                <td><button type="button" class="btn btn-sm btn-danger" onclick="this.closest('tr').remove(); calculatePayroll();">x</button></td>
            </tr>`;
            document.querySelector("#allowancesTable tbody").insertAdjacentHTML('beforeend', row);
            calculatePayroll();
        }

        function addDeductionRow() {
            let row = `
            <tr>
                <td><input type="text" name="deductions[name][]" class="form-control"></td>
                <td><input type="number" name="deductions[amount][]" class="form-control deduction-amount" oninput="calculatePayroll()"></td>
                <td><button type="button" class="btn btn-sm btn-danger" onclick="this.closest('tr').remove(); calculatePayroll();">x</button></td>
            </tr>`;
            document.querySelector("#deductionsTable tbody").insertAdjacentHTML('beforeend', row);
            calculatePayroll();
        }

        document.addEventListener('DOMContentLoaded', function() {
            calculatePayroll();

            document.querySelectorAll(
                '#base_salary, .allowance-amount, .deduction-amount, #ptkp_status'
            ).forEach(el => {
                el.addEventListener('input', calculatePayroll);
                el.addEventListener('change', calculatePayroll);
            });
        });
        document.getElementById('payrollForm').addEventListener('submit', function(e) {
            e.preventDefault();

            let employeeId = document.querySelector('input[name="employee_id"]').value;
            let month = document.querySelector('input[name="month"]').value;

            fetch(`{{ route('payrolls.checkCode') }}?employee_id=${employeeId}&month=${month}`)
                .then(res => res.json())
                .then(data => {
                    if (data.exists) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal!',
                            text: `Payroll untuk karyawan ini di bulan ${month} sudah ada.`,
                        });
                    } else {
                        document.getElementById('payrollForm').submit();
                    }
                })
                .catch(err => {
                    console.error(err);
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops!',
                        text: 'Terjadi kesalahan saat memeriksa kode payroll.',
                    });
                });
        });
    </script>



@endsection
