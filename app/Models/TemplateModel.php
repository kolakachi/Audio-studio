<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TemplateModel extends Model
{
    use HasFactory;
    protected $table = "templates";

    protected $casts = [
        'tags' => 'array' 
    ];

}
