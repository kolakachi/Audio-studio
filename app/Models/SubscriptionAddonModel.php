<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SubscriptionAddonModel extends Model
{
    protected $table = 'addon_subscriptions';
    protected $connection = 'mysql';


    protected $casts = [
        'status' => 'boolean'
    ];
    protected $fillable = [
        'subscription_id',
        'name'
    ];

    public function getEndDateAttribute($value){
        if($value){
            return date("d-M-Y", $value);
        }

        return $value;
        // return $this->getSubscriptions($this->id);
    }
}
