<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Comment;
use App\Models\Like;
use App\Models\Volume;
use App\Models\Episode;
class MangaInformation extends Model
{
    use HasFactory;
    protected $fillable = [
        'manga_name',
        'alternative_name',
        'author',
        'visual_key',
        'release_date',
        'status',
        'description',
        'rating',
        'users'
    ];

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
    public function likes()
    {
        return $this->hasMany(Like::class);
    }
    public function volumes()
    {
        return $this->hasMany(Volume::class);
    }
    public function episodes()
    {
        return $this->hasMany(Episode::class);
    }
    public function admins()
    {
        return $this->hasOne(admin::class);
    }
}
