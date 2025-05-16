<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    protected $fillable = [
        'title',
        'author',
        'description',
        'genre',
        'image',
        'price',
        'quantity',
    ];

    public function ratings()
    {
        return $this->hasMany(Rating::class);
    }

    public function likes()
    {
        return $this->hasMany(Like::class);
    }
}
