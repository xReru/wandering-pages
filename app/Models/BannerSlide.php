<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BannerSlide extends Model
{
    protected $fillable = [
        'book_id',
        'status',
        'type',
        'order'
    ];

    public function book()
    {
        return $this->belongsTo(Book::class);
    }

    public function getStatusLabelAttribute()
    {
        return ucfirst($this->status);
    }

    public function getTypeLabelAttribute()
    {
        return str_replace('_', ' ', ucfirst($this->type));
    }
} 