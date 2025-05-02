<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'poster',
        'content_type',
        'background_color',
        'text_color'
    ];

    protected $casts = [
        'order' => 'integer',
        'is_active' => 'boolean',
    ];

    public function getPosterUrlAttribute()
    {
        return $this->poster;
    }

    public function videos()
    {
        return $this->hasMany(Video::class);
    }

    public function audioBooks()
    {
        return $this->hasMany(AudioBook::class);
    }

    public function pdfs()
    {
        return $this->hasMany(Pdf::class);
    }
}
