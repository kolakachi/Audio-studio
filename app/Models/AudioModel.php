<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AudioModel extends Model
{
    use HasFactory;

    protected $table ="audios";

    protected $casts = [
        'layers' => 'array'
    ];
}
