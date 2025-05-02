<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    use HasFactory;

    protected $fillable = [
        'child_id',
        'activityable_type',
        'activityable_id',
        'type',
    ];

    public function child()
    {
        return $this->belongsTo(Child::class);
    }

    public function activityable()
    {
        return $this->morphTo();
    }
} 