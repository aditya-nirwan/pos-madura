<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MonthlyRevenues extends Model
{
    use HasFactory;

    protected $fillable = ['year', 'month', 'income'];
}