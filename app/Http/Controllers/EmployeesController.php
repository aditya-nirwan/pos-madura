<?php

namespace App\Http\Controllers;

use App\Models\Employees;
use App\Models\Position;
use Illuminate\Http\Request;

class EmployeesController extends Controller
{
    public function index()
    {
        $employees = Employees::with('position')->get();
        return view('employees.index', compact('employees'));
    }

    public function create()
    {
        $positions = Position::all();
        return view('employees.create', compact('positions'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'employee_code' => 'required|unique:employees,employee_code',
            'name' => 'required',
            'position_id' => 'required|exists:positions,id',
            'address' => 'nullable|string',
            'phone_number' => 'nullable|string',
            'gender' => 'nullable|in:M,F',
            'birth_date' => 'nullable|date',
        ]);

        $employee = new Employees();
        $employee->employee_code = $request->employee_code;
        $employee->name = $request->name;
        $employee->position_id = $request->position_id;
        $employee->ptkp_status = $request->ptkp_status;
        $employee->address = $request->address;
        $employee->phone_number = $request->phone_number;
        $employee->gender = $request->gender;
        $employee->birth_date = $request->birth_date;
        $employee->save();

        return redirect()->route('employees.index')->with('success', 'Berhasil Tambah Karyawan.');
    }

    public function edit($id)
    {
        $employee = Employees::findOrFail($id);
        $positions = Position::all();
        return view('employees.edit', compact('employee', 'positions'));
    }

    public function update(Request $request, $id)
    {
        $employee = Employees::findOrFail($id);

        $employee->employee_code = $request->employee_code;
        $employee->name = $request->name;
        $employee->position_id = $request->position_id;
        $employee->ptkp_status = $request->ptkp_status;
        $employee->address = $request->address;
        $employee->phone_number = $request->phone_number;
        $employee->gender = $request->gender;
        $employee->birth_date = $request->birth_date;
        $employee->save();

        return redirect()->route('employees.index')->with('success', 'Berhasil Update data Karyawan.');
    }

    public function destroy($id)
    {
        $employee = Employees::findOrFail($id);
        $employee->delete();

        return redirect()->route('employees.index')->with('success', 'Berhasil hapus data.');
    }
}