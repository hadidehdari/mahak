<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Video extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'title',
        'slug',
        'description',
        'thumbnail',
        'video_url',
        'duration',
        'file_size',
        'background_color',
        'category_id',
        'creator_id',
        'age_group_id',
        'is_featured',
        'is_active',
        'rating',
        'rating_count'
    ];

    protected $casts = [
        'is_featured' => 'boolean',
        'is_active' => 'boolean',
        'duration' => 'integer',
        'views_count' => 'integer',
        'rating' => 'decimal:2',
        'rating_count' => 'integer'
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

    public function activities()
    {
        return $this->morphMany(Activity::class, 'activityable');
    }
}
