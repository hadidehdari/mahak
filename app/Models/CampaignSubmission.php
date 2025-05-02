<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CampaignSubmission extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'campaign_id',
        'user_id',
        'title',
        'description',
        'file',
        'is_winner'
    ];

    protected $casts = [
        'is_winner' => 'boolean'
    ];

    public function campaign()
    {
        return $this->belongsTo(Campaign::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
} 