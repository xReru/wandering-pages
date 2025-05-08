<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BannerSlide extends Model
{
    protected $fillable = [
        'title',
        'author',
        'description',
        'image_path',
        'status',
        'type',
        'button_text',
        'button_link',
        'order'
    ];

    public function getStatusLabelAttribute()
    {
        return ucfirst($this->status);
    }

    public function getTypeLabelAttribute()
    {
        return str_replace('_', ' ', ucfirst($this->type));
    }
} 