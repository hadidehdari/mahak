<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Child extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'name',
        'birth_date',
        'gender',
        'profile_photo',
        'is_active',
    ];

    protected $casts = [
        'birth_date' => 'date',
        'is_active' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function activities()
    {
        return $this->hasMany(ChildActivity::class);
    }

    public function getFullNameAttribute()
    {
        return "{$this->first_name} {$this->last_name}";
    }

    public function getAgeGroupTextAttribute()
    {
        return match($this->age_group) {
            '6_and_below' => '6 سال و پایین‌تر',
            '7_to_9' => '7 تا 9 سال',
            '10_to_12' => '10 تا 12 سال',
            default => 'نامشخص'
        };
    }

    public function getGenderTextAttribute()
    {
        return $this->gender === 'male' ? 'پسر' : 'دختر';
    }
} 