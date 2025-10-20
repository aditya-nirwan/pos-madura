<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'category_id',
        'name',
        'description',
        'buy_price',
        'sell_price',
        'stock',
        'discount',
        'image'
    ];
    public function setCodeAttribute($value)
    {
        $this->attributes['code'] = strtoupper($value);
    }
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function barcode()
    {
        return $this->hasOne(ProductBarcode::class);
    }
}