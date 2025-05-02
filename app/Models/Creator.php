<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Creator extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'slug',
        'photo',
        'description'
    ];

    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($creator) {
            if (empty($creator->slug)) {
                $creator->slug = Str::slug($creator->name);
            }
        });
    }

    public function getPhotoUrlAttribute()
    {
        return $this->photo;
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