<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class AgeGroup extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'slug',
        'min_age',
        'max_age',
        'is_active'
    ];

    protected $casts = [
        'min_age' => 'integer',
        'max_age' => 'integer',
        'is_active' => 'boolean'
    ];

    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($ageGroup) {
            if (empty($ageGroup->slug)) {
                $ageGroup->slug = Str::slug($ageGroup->name);
            }
        });
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