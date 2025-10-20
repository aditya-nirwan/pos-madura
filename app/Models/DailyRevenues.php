<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DailyRevenues extends Model
{
    use HasFactory;

    protected $fillable = ['date', 'income', 'total_tax'];
}