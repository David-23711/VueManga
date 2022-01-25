<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Episode;
use App\Models\MangaInformation;
class Volume extends Model
{
    use HasFactory;
    protected $fillable = [
     'manga_information_id',
     'volume',
    ];

    public function episodes()
    {
        return $this->hasMany(Episode::class);
    }
    public function manga_information()
    { 
       return $this->belongsTo(MangaInformation::class,'manga_information_id');  
    }
}
