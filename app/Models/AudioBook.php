<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AudioBook extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'title',
        'slug',
        'description',
        'cover_image',
        'category_id',
        'creator_id',
        'age_group_id',
        'is_featured',
        'is_active',
    ];

    protected $casts = [
        'is_featured' => 'boolean',
        'is_active' => 'boolean',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function creator()
    {
        return $this->belongsTo(Creator::class);
    }

    public function ageGroup()
    {
        return $this->belongsTo(AgeGroup::class);
    }

    public function slides()
    {
        return $this->hasMany(AudioBookSlide::class)->orderBy('order');
    }

    public function activities()
    {
        return $this->morphMany(Activity::class, 'activityable');
    }
} 