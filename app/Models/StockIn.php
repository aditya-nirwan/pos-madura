<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StockIn extends Model
{
    use HasFactory;

    protected $fillable = ['code', 'user_id', 'subtotal', 'other_cost', 'total'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function products()
    {
        return $this->hasMany(StockInProduct::class);
    }

    public function others()
    {
        return $this->hasMany(StockInOther::class);
    }
    public function details()
    {
        return $this->hasMany(StockInDetail::class);
    }
}