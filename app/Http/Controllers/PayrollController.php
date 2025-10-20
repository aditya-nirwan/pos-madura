<?php

namespace App\Http\Controllers;

use App\Models\Allowances;
use App\Models\Attend;
use App\Models\Deduction;
use App\Models\Employees;
use App\Models\Payroll;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PayrollController extends Controller
{
    public function show()
    {
        $employees = Employees::with('position')->get();

        return view('payroll.show', compact('employees'));
    }

    public function create(Request $request)
    {
        $employeeId = $request->employee_id;
        $month = $request->month;

        $employee = Employees::with('position')->findOrFail($employeeId);

        $attendances = Attend::where('employee_id', $employeeId)
            ->whereMonth('date', date('m', strtotime($month)))
            ->whereYear('date', date('Y', strtotime($month)))
            ->get();

        $izin = $attendances->where('status', 'permission')->count();
        $tanpaIzin = $attendances->where('status', 'absent')->count();
        $sakit = $attendances->where('status', 'sick')->count();

        $potonganAbsensi = ($izin * 40000) + ($tanpaIzin * 80000);

        return view('payroll.create', compact('employee', 'month', 'izin', 'tanpaIzin', 'sakit', 'potonganAbsensi'));
    }


    public function store(Request $request)
    {
        $validated = $request->validate([
            'employee_id' => ['required', 'exists:employees,id'],
            'month'       => ['required', 'date_format:Y-m'],
        ]);

        DB::beginTransaction();
        try {
            $periodYm = str_replace('-', '', $validated['month']);

            $payroll = Payroll::where('employee_id', $validated['employee_id'])
                ->where('month', $validated['month'])
                ->first();

            if (!$payroll) {
                $payroll = new Payroll();
                $payroll->code = "PY-{$periodYm}-{$validated['employee_id']}";
                $payroll->employee_id = $validated['employee_id'];
                $payroll->month = $validated['month'];
            }


            $payroll->addition_salary      = $request->addition_salary ?? 0;
            $payroll->deduction_salary     = $request->deduction_salary ?? 0;
            $payroll->attendance_deduction = $request->attendance_deduction ?? 0;
            $payroll->gross_salary         = $request->gross_salary ?? 0;
            $payroll->pph_21_tax           = $request->pph_21_tax ?? 0;
            $payroll->take_home_pay        = $request->take_home_pay ?? 0;
            $payroll->save();

            Allowances::where('payroll_id', $payroll->id)->delete();
            if ($request->has('allowances')) {
                foreach ($request->allowances['name'] as $i => $name) {
                    $amount = $request->allowances['amount'][$i] ?? null;
                    if (!empty($name) && !empty($amount)) {
                        Allowances::create([
                            'payroll_id'  => $payroll->id,
                            'employee_id' => $payroll->employee_id,
                            'name'        => $name,
                            'amount'      => $amount,
                        ]);
                    }
                }
            }

            Deduction::where('payroll_id', $payroll->id)->delete();
            if ($request->has('deductions')) {
                foreach ($request->deductions['name'] as $i => $name) {
                    $amount = $request->deductions['amount'][$i] ?? null;
                    if (!empty($name) && !empty($amount)) {
                        Deduction::create([
                            'payroll_id'  => $payroll->id,
                            'employee_id' => $payroll->employee_id,
                            'name'        => $name,
                            'amount'      => $amount,
                        ]);
                    }
                }
            }

            DB::commit();
            return redirect()->route('payroll.show')->with('success', 'Gaji Karyawan berhasil disimpan.');
        } catch (\Throwable $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }



    public function checkCode(Request $request)
    {
        $employeeId = $request->employee_id;
        $month = $request->month;

        $exists = Payroll::where('employee_id', $employeeId)
            ->where('month', $month)
            ->exists();

        return response()->json(['exists' => $exists]);
    }


    public function rekap(Request $request)
    {
        $month = $request->get('month', date('Y-m'));

        $payrolls = Payroll::with('employee.position')
            ->where('month', $month)
            ->get();


        return view('payroll.rekap', compact('payrolls', 'month'));
    }


    public function rekapTunjangan(Request $request)
    {
        $month = $request->get('month', date('Y-m'));

        $allowances = Allowances::with('employee')
            ->join('payrolls', 'allowances.payroll_id', '=', 'payrolls.id')
            ->join('employees', 'allowances.employee_id', '=', 'employees.id')
            ->select(
                'employees.name as employee_name',
                'allowances.name as allowance_name',
                'allowances.amount',
                'payrolls.month as payroll_month'
            )
            ->where('payrolls.month', $month)
            ->orderBy('employees.name')
            ->get();

        return view('payroll.tunjangan', compact('allowances', 'month'));
    }


    public function rekapPotongan(Request $request)
    {
        $month = $request->get('month', date('Y-m'));

        $deductions = Deduction::with('employee')
            ->join('payrolls', 'deductions.payroll_id', '=', 'payrolls.id')
            ->join('employees', 'deductions.employee_id', '=', 'employees.id')
            ->select(
                'employees.name as employee_name',
                'deductions.name as deduction_name',
                'deductions.amount',
                'payrolls.month as payroll_month'

            )
            ->where('payrolls.month', $month)
            ->orderBy('employees.name')
            ->get();

        return view('payroll.potongan', compact('deductions', 'month'));
    }
}