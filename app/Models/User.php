<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes;

    public function getProfilePhotoUrlAttribute()
    {
        if (!$this->profile_photo) {
            return 'https://ui-avatars.com/api/?name=' . urlencode($this->name) . '&color=7F9CF5&background=EBF4FF&size=150';
        }
        
        return $this->profile_photo;
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'phone',
        'email',
        'password',
        'is_admin',
        'is_active',
        'role',
        'profile_photo_path',
        'profile_photo'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_admin' => 'boolean',
            'is_active' => 'boolean',
        ];
    }

    public function children()
    {
        return $this->hasMany(Child::class);
    }

    public function activities()
    {
        return $this->hasManyThrough(Activity::class, Child::class);
    }

    public function isAdmin()
    {
        return $this->is_admin || $this->role === 'admin';
    }

    public function isParent()
    {
        return $this->role === 'parent';
    }
}
