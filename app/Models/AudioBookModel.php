<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AudioBookModel extends Model
{
    use HasFactory;

    protected $table ="audio_books";

    protected $casts = [
        'layers' => 'array'
    ];
}
