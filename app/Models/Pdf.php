<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Pdf extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'title',
        'slug',
        'description',
        'thumbnail',
        'file_url',
        'pages_count',
        'category_id',
        'creator_id',
        'age_group_id',
        'is_featured',
        'is_active',
    ];

    protected $casts = [
        'pages_count' => 'integer',
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

    public function activities()
    {
        return $this->morphMany(Activity::class, 'activityable');
    }
} 