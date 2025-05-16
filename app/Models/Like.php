<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Like extends Model
{
    protected $fillable = ['customer_id', 'book_id'];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function book()
    {
        return $this->belongsTo(Book::class);
    }
}
