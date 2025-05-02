<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Campaign extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'title',
        'slug',
        'description',
        'banner_image',
        'start_date',
        'end_date',
        'is_active',
        'is_featured',
    ];

    protected $casts = [
        'start_date' => 'datetime',
        'end_date' => 'datetime',
        'is_active' => 'boolean',
        'is_featured' => 'boolean',
    ];

    public function submissions()
    {
        return $this->hasMany(CampaignSubmission::class);
    }

    public function winners()
    {
        return $this->hasMany(CampaignSubmission::class)->where('is_winner', true);
    }
} 