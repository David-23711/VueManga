<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class bookmark extends Model
{
    use HasFactory;
    protected $fillable=[
        'manga_information_id',
        'user_id'
    ];
}
