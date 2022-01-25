<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Volume;

class Episode extends Model
{
    use HasFactory;
    protected $fillable = [
        'volume_id',
        'manga_information_id',
        'episode_name'
    ];
    public function volume()
    {
        $this->belongsTo(Volume::class);
    }

}
