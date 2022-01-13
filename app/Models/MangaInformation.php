<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MangaInformation extends Model
{
    use HasFactory;
    protected $fillable = [
        'category_name',
        'manga_name',
        'alternative_name',
        'visual_key',
        'release_date',
        'status'
    ];

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
    public function likes()
    {
        return $this->hasMany(Like::class);
    }
    
}
