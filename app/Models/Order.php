<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'transaction_no',
        'total_amount',
        'shipping_fee',
        'shipping_method',
        'payment_method',
        'payment_proof',
        'status',
        'shipping_address'
    ];

    public function user()
    {
        return $this->belongsTo(Customer::class, 'user_id');
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }
}
