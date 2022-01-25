<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MultiImage extends Model
{
    use HasFactory;
    protected $fillable = [
     'manga_information_id',
     'volume_id',
     'episode_id',
     'manga_image',
     'image_name',
    ];
}
