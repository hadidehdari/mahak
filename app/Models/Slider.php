<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Slider extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'image',
        'link',
        'type',
        'target_id',
        'order',
        'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean'
    ];

    public function target()
    {
        switch ($this->type) {
            case 'category':
                return $this->belongsTo(Category::class, 'target_id');
            case 'video':
                return $this->belongsTo(Video::class, 'target_id');
            case 'audiobook':
                return $this->belongsTo(AudioBook::class, 'target_id');
            case 'campaign':
                return $this->belongsTo(Campaign::class, 'target_id');
            default:
                return null;
        }
    }
} 