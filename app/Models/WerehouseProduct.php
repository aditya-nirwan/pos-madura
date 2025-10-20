<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WerehouseProduct extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'name',
        'description',
        'category_id',
        'unit_id',
        'stock',
        'buy_price',
    ];

    public function stockInProducts()
    {
        return $this->hasMany(StockInProduct::class, 'product_id');
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function unit()
    {
        return $this->belongsTo(Unit::class);
    }
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}