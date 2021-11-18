<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Script extends Model
{
    use HasFactory;

    public $fillable = [
        'name',
        'slug',
        'contents'
    ];
}
