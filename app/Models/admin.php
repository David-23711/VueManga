<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\MangaInformation;

class admin extends Model
{
    use HasFactory;
    protected $fillable = [
      'admin',
      'email',
      'avatar',
      'password',
      'phone',
      'address',

    ];
    protected $table = "admins";
    public function mangaInfos()
    {
        return $this->hasMany(MangaInformation::class);
    }
}
