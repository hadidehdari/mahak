<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AudioBookSlide extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'audio_book_id',
        'title',
        'description',
        'image',
        'audio_url',
        'duration',
        'order'
    ];

    protected $casts = [
        'duration' => 'integer',
        'order' => 'integer',
    ];

    public function audioBook()
    {
        return $this->belongsTo(AudioBook::class);
    }
} 