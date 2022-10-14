<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserSubConfigModel extends Model
{
    protected $table = 'user_subscription_configs';

    protected $casts = [
        'config' => 'array'
    ];

    protected $fillable = [
        'user_id',
    ];
}
