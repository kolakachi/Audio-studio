<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SubscriptionModel extends Model
{
    protected $table = 'ipn_subscriptions';
    protected $connection = 'mysql';

    protected $casts = [
        'status' => 'boolean'
    ];

    protected $fillable = [
        'user_id',
        'name'
    ];

    public function addons(){
		return $this->hasMany('App\Models\SubscriptionAddonModel', 'subscription_id', 'id');
    }
}
