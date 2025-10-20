<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employees extends Model
{
    use HasFactory;

    protected $fillable = [
        'employee_code',
        'name',
        'position_id',
        'address',
        'phone_number',
        'gender',
        'birth_date',
    ];

    public function position()
    {
        return $this->belongsTo(Position::class);
    }

    public function attendances()
    {
        return $this->hasMany(Attend::class);
    }

    public function payrolls()
    {
        return $this->hasMany(Payroll::class, 'employee_id');
    }
}