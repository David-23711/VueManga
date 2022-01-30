<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\MangaInformation;

class Genre extends Model
{
    use HasFactory;
    protected $fillable = [
        'genre',
        'manga_information_id'
    ];
    public function manga_information()
    {
       return $this->hasOne(MangaInformation::class);
    }
}
