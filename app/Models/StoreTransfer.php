<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StoreTransfer extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'product_id',
        'from_warehouse_id',
        'qty',
        'price',
        'total',
        'description',
        'user_id'
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}