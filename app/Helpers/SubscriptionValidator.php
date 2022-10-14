<?php

use App\Models\User;
use App\Helpers\PaymentConfig;
use Illuminate\Support\Facades\Log;
use App\Models\SubscriptionModel;
use App\Models\UserSubConfigModel;
use App\Models\SubscriptionAddonModel;

function userHasAccessToEnterprise($userId){

    $user = User::where('id', $userId)->first();

    if(!$user){
        return false;
    }
    $subscription = SubscriptionModel::where('user_id', $user->id)->where('status', true)->first();


    if($user->role == 'admin' || $user->role == 'support' ||  $user->role == 'reviewer'){
        return true;
    }

    if(!$subscription){
        return false;
    }

    $subConfig = UserSubConfigModel::where('user_id',$userId)->first();
    if(!$subConfig){
        return false;
    }

    $addon = SubscriptionAddonModel::where('status', true)
        ->where('name', PaymentConfig::OTO_ENTERPRISE)
        ->where('subscription_id', $subscription->id)->first();
    if($addon){
        return true;
    }

    $config = $subConfig->config;

    return (bool) $config['has_access_to_agency'];


    return false;
}

function userHasAccessToReseller($userId){
    $user = User::where('id', $userId)->first();

    if(!$user){
        return false;
    }
    $subscription = SubscriptionModel::where('user_id', $user->id)->where('status', true)->first();


    if($user->role == 'admin' || $user->role == 'support' ||  $user->role == 'reviewer'){
        return true;
    }

    if(!$subscription){
        return false;
    }

    $subConfig = UserSubConfigModel::where('user_id',$userId)->first();
    if(!$subConfig){
        return false;
    }

    $addon = SubscriptionAddonModel::where('status', true)
        ->where('name', PaymentConfig::OTO_WHITELABEL_AND_RESELLER_2)
        ->where('subscription_id', $subscription->id)->first();

    $addon2 = SubscriptionAddonModel::where('status', true)
        ->where('name', PaymentConfig::OTO_WHITELABEL_AND_RESELLER)
        ->where('subscription_id', $subscription->id)->first();
    if($addon || $addon2){
        return true;
    }

    $config = $subConfig->config;

    return (bool) $config['has_access_to_reseller'];


    return false;
}

function getNumberOfAudioOutput($userId){
    $user = User::where('id', $userId)->first();

    if(!$user){
        return 1;
    }
    $subscription = SubscriptionModel::where('user_id', $user->id)->where('status', true)->first();


    if($user->role == 'admin' || $user->role == 'support' ||  $user->role == 'reviewer'){
        return 3;
    }

    if(!$subscription){
        return 1;
    }

    $subConfig = UserSubConfigModel::where('user_id',$userId)->first();
    if(!$subConfig){
        return 1;
    }

    $config = $subConfig->config;

    return $config['sum_of_audio_output_format'];

}

function getNumberOfLayers($userId){
    $user = User::where('id', $userId)->first();

    if(!$user){
        return 2;
    }
    $subscription = SubscriptionModel::where('user_id', $user->id)->where('status', true)->first();


    if($user->role == 'admin' || $user->role == 'support' ||  $user->role == 'reviewer'){
        return 100;
    }

    if(!$subscription){
        return 2;
    }

    $subConfig = UserSubConfigModel::where('user_id',$userId)->first();
    if(!$subConfig){
        return 2;
    }

    $config = $subConfig->config;

    return $config['sum_of_layers'];

}

function userHasAccessToRecorder($userId){

    $user = User::where('id', $userId)->first();

    if(!$user){
        return false;
    }
    $subscription = SubscriptionModel::where('user_id', $user->id)->where('status', true)->first();


    if($user->role == 'admin' || $user->role == 'support' ||  $user->role == 'reviewer'){
        return true;
    }

    if(!$subscription){
        return false;
    }

    $subConfig = UserSubConfigModel::where('user_id',$userId)->first();
    if(!$subConfig){
        return false;
    }

    $config = $subConfig->config;

    return (bool) $config['has_access_to_recorder'];

}

function userHasAccessToTeleprompter($userId){

    $user = User::where('id', $userId)->first();

    if(!$user){
        return false;
    }
    $subscription = SubscriptionModel::where('user_id', $user->id)->where('status', true)->first();


    if($user->role == 'admin' || $user->role == 'support' ||  $user->role == 'reviewer'){
        return true;
    }

    if(!$subscription){
        return false;
    }

    $subConfig = UserSubConfigModel::where('user_id',$userId)->first();
    if(!$subConfig){
        return false;
    }

    $config = $subConfig->config;

    return (bool) $config['has_access_to_teleprompter'];

}

function userHasAccessToMasterpiece($userId){

    $user = User::where('id', $userId)->first();

    if(!$user){
        return false;
    }
    $subscription = SubscriptionModel::where('user_id', $user->id)->where('status', true)->first();


    if($user->role == 'admin' || $user->role == 'support' ||  $user->user_type == 'reviewer'){
        return true;
    }

    if(!$subscription){
        return false;
    }

    $subConfig = UserSubConfigModel::where('user_id',$userId)->first();
    if(!$subConfig){
        return false;
    }

    $config = $subConfig->config;

    return (bool) $config['has_access_to_masterpiece'];

}

function userHasAccessToMasterpieceRequests($userId){
    $user = User::where('id', $userId)->first();
    $subscription = SubscriptionModel::where('user_id', $userId)->first();

    if(!$user){
        return false;
    }

    if($user->role == 'admin' || $user->role == 'support' || $user->role == 'reviewer'){
        return true;
    }

    $subConfig = UserSubConfigModel::where('user_id',$userId)->first();
    if(!$subConfig){
        return false;
    }

    $config = $subConfig->config;
    $duration = $config['masterpiece_duration'];
    $searchCount = $config['masterpiece_requests_remaining'];
    $now = strtotime('now');

    if($now < $duration){
        if($searchCount > 0){
            $searchCount = $searchCount -1;
            $config['masterpiece_requests_remaining'] = $searchCount;
            $subConfig->config = $config;
            $subConfig->save();

            return true;


        }
    }else{
        $addon = SubscriptionAddonModel::where('status', true)
        ->where('name', PaymentConfig::OTO_UNLIMITED_OR_BUSINESS)
        ->where('subscription_id', $subscription->id)->first();

        $config['masterpiece_duration'] = strtotime("+1 month");
        if($addon){
            $config['masterpiece_requests_remaining'] = 100;
        }else{
            $config['masterpiece_requests_remaining'] = 99999999999999;
        }
        
        $subConfig->config = $config;
        $subConfig->save();

        return true;
        
    }

    return false;
}

function getNumberOfSounds($userId){
    $user = User::where('id', $userId)->first();

    if(!$user){
        return 1;
    }
    $subscription = SubscriptionModel::where('user_id', $user->id)->where('status', true)->first();


    if($user->role == 'admin' || $user->role == 'support' ||  $user->role == 'reviewer'){
        return 9999999999999999;
    }

    if(!$subscription){
        return 1;
    }

    $subConfig = UserSubConfigModel::where('user_id',$userId)->first();
    if(!$subConfig){
        return 1;
    }

    $config = $subConfig->config;

    return $config['sum_of_stock_background_sound'];

}

function getNumberOfMusic($userId){
    $user = User::where('id', $userId)->first();

    if(!$user){
        return 1;
    }
    $subscription = SubscriptionModel::where('user_id', $user->id)->where('status', true)->first();


    if($user->role == 'admin' || $user->role == 'support' ||  $user->role == 'reviewer'){
        return 9999999999999999;
    }

    if(!$subscription){
        return 1;
    }

    $subConfig = UserSubConfigModel::where('user_id',$userId)->first();
    if(!$subConfig){
        return 1;
    }

    $config = $subConfig->config;

    return $config['sum_of_stock_background_music'];

}

function getNumberOfLanguages($userId){
    $user = User::where('id', $userId)->first();

    if(!$user){
        return 1;
    }
    $subscription = SubscriptionModel::where('user_id', $user->id)->where('status', true)->first();


    if($user->role == 'admin' || $user->role == 'support' ||  $user->role == 'reviewer'){
        return 9999999999999999;
    }

    if(!$subscription){
        return 1;
    }

    $subConfig = UserSubConfigModel::where('user_id',$userId)->first();
    if(!$subConfig){
        return 1;
    }

    $config = $subConfig->config;

    return $config['sum_of_languages'];

}

