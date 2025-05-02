<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChildActivity extends Model
{
    use HasFactory;

    protected $fillable = [
        'child_id',
        'activity_type',
        'activity_id',
        'duration',
        'completed_at',
        'status',
        'notes'
    ];

    protected $casts = [
        'completed_at' => 'datetime',
        'duration' => 'integer'
    ];

    public function child()
    {
        return $this->belongsTo(Child::class);
    }

    public function activity()
    {
        return $this->morphTo();
    }
} 