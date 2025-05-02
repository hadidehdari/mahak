<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Page extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'title',
        'slug',
        'route_name',
        'route_path',
        'meta_title',
        'meta_description',
        'content',
        'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean'
    ];

    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($page) {
            if (empty($page->slug)) {
                $page->slug = Str::slug($page->title);
            }
            if (empty($page->route_name)) {
                $page->route_name = Str::slug($page->title);
            }
            if (empty($page->route_path)) {
                $page->route_path = Str::slug($page->title);
            }
        });

        static::updating(function ($page) {
            if (empty($page->slug)) {
                $page->slug = Str::slug($page->title);
            }
            if (empty($page->route_name)) {
                $page->route_name = Str::slug($page->title);
            }
            if (empty($page->route_path)) {
                $page->route_path = Str::slug($page->title);
            }
        });
    }

    public function getRouteAttribute()
    {
        return [
            'name' => $this->route_name,
            'path' => $this->route_path
        ];
    }

    public static function findByRoute($routeName, $routePath)
    {
        return static::where('route_name', $routeName)
                    ->orWhere('route_path', $routePath)
                    ->first();
    }
} 