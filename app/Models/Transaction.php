<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $table = 'transactions';

    protected $fillable = [
        'code',
        'cashier_id',
        'subtotal',
        'total_discount',
        'total_tax',
        'total_cost',
    ];
    public function items()
    {
        return $this->hasMany(TransactionItem::class, 'transaction_id', 'id');
    }

    public function cashier()
    {
        return $this->belongsTo(Cashier::class, 'cashier_id');
    }
}