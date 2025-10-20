<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StockInOther extends Model
{
    use HasFactory;

    protected $fillable = ['stock_in_id', 'name', 'total'];

    public function stockIn()
    {
        return $this->belongsTo(StockIn::class);
    }
}