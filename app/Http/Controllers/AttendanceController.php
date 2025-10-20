<?php

namespace App\Http\Controllers;

use App\Models\Attend;
use App\Models\Employees;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AttendanceController extends Controller
{
    public function index(Request $request)
    {
        $date = $request->date ?? date('Y-m-d'); // default hari ini
        $employees = Employees::all();

        // Ambil absensi untuk tanggal terpilih
        $attendances = Attend::where('date', $date)->get()->keyBy('employee_id');

        return view('attend.show', compact('employees', 'attendances', 'date'));
    }

    public function store(Request $request)
    {
        $attendances = $request->attendances;

        foreach ($attendances as $data) {
            $proofImageName = null;

            if (isset($data['proof_image']) && $data['proof_image'] instanceof \Illuminate\Http\UploadedFile) {
                $file = $data['proof_image'];
                $proofImageName = 'attendance-' . date("YmdHis") . '-' . $data['employee_id'] . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('attendance_letters'), $proofImageName);
            }

            $attend = Attend::updateOrCreate(
                ['employee_id' => $data['employee_id'], 'date' => $data['date']],
                ['status' => $data['status'], 'proof_image' => $proofImageName]
            );
        }

        return redirect('absensi?date=' . $request->date)
            ->with('success', 'Absensi Berhasil Disimpan');
    }

    public function rekap(Request $request)
    {
        $month = $request->month ?? date('Y-m'); // default bulan ini
        $start = $month . '-01';
        $end = date("Y-m-t", strtotime($start)); // akhir bulan

        $employees = Employees::all();

        // Ambil semua absensi pada bulan tersebut
        $attendances = Attend::whereBetween('date', [$start, $end])->get();

        // Group berdasarkan karyawan
        $rekap = [];
        foreach ($employees as $employee) {
            $userAttendance = $attendances->where('employee_id', $employee->id);

            $rekap[] = [
                'employee'   => $employee,
                'present'    => $userAttendance->where('status', 'present')->count(),
                'permission' => $userAttendance->where('status', 'permission')->count(),
                'sick'       => $userAttendance->where('status', 'sick')->count(),
                'absent'     => $userAttendance->where('status', 'absent')->count(),
                'total_days' => $userAttendance->count(),
            ];
        }

        return view('attend.rekap', compact('rekap', 'month'));
    }
}