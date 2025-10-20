<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payroll extends Model
{
    use HasFactory;

    protected $fillable = [
        'employee_id',
        'month',
        'attendance_deduction',
        'addition_salary',
        'deduction_salary',
        'gross_salary',
        'pph_21_tax',
        'take_home_pay',
    ];

    public function employee()
    {
        return $this->belongsTo(Employees::class, 'employee_id');
    }

    public function allowances()
    {
        return $this->hasMany(Allowances::class);
    }

    public function deductions()
    {
        return $this->hasMany(Deduction::class);
    }

    public function getTotalAllowancesAttribute()
    {
        return $this->allowances->sum('amount');
    }

    public function getTotalDeductionsAttribute()
    {
        return $this->deductions->sum('amount');
    }
}
