<?php

use App\Models\User;
use App\Helpers\PaymentConfig;
use Illuminate\Support\Facades\Log;
use App\Models\SubscriptionModel;
use App\Models\UserSubConfigModel;
use App\Models\SubscriptionAddonModel;
use App\Models\WhiteLabelConfigModel;


function userHasAccessToEnterprise($userId){

    $user = User::where('id', $userId)->first();

    if(!$user){
        return false;
    }
    
    if($user->account_type == 'whitelabel' || $user->account_type == 'agency'){
        $user = User::where('id', $user->admin_id)->first();
    }

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

    $Bundlesubscription1 = SubscriptionModel::where('user_id', $userId)
        ->where('name', PaymentConfig::FRONTEND_BUNDLE_1)->first();
    $Bundlesubscription2 = SubscriptionModel::where('user_id', $userId)
    ->where('name', PaymentConfig::FRONTEND_BUNDLE_1)->first();
    if($Bundlesubscription1 || $Bundlesubscription2){
        return true;
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

    if($user->account_type == 'whitelabel' || $user->account_type == 'agency'){
        $user = User::where('id', $user->admin_id)->first();
    }

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

    $Bundlesubscription1 = SubscriptionModel::where('user_id', $userId)
        ->where('name', PaymentConfig::FRONTEND_BUNDLE_1)->first();
    $Bundlesubscription2 = SubscriptionModel::where('user_id', $userId)
    ->where('name', PaymentConfig::FRONTEND_BUNDLE_1)->first();
    if($Bundlesubscription1 || $Bundlesubscription2){
        return true;
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

    if($user->account_type == 'whitelabel' || $user->account_type == 'agency'){
        $user = User::where('id', $user->admin_id)->first();
    }

    if(!$user){
        return 1;
    }

    $subscription = SubscriptionModel::where('user_id', $user->id)->where('status', true)->first();


    if($user->role == 'admin' || $user->role == 'support' ||  $user->role == 'reviewer'){
        return 3;
    }

    $Bundlesubscription1 = SubscriptionModel::where('user_id', $userId)
        ->where('name', PaymentConfig::FRONTEND_BUNDLE_1)->first();
    $Bundlesubscription2 = SubscriptionModel::where('user_id', $userId)
    ->where('name', PaymentConfig::FRONTEND_BUNDLE_1)->first();
    if($Bundlesubscription1 || $Bundlesubscription2){
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

    if($user->account_type == 'whitelabel' || $user->account_type == 'agency'){
        $user = User::where('id', $user->admin_id)->first();
    }

    if(!$user){
        return 2;
    }

    $subscription = SubscriptionModel::where('user_id', $user->id)->where('status', true)->first();


    if($user->role == 'admin' || $user->role == 'support' ||  $user->role == 'reviewer'){
        return 100;
    }

    $Bundlesubscription1 = SubscriptionModel::where('user_id', $userId)
        ->where('name', PaymentConfig::FRONTEND_BUNDLE_1)->first();
    $Bundlesubscription2 = SubscriptionModel::where('user_id', $userId)
    ->where('name', PaymentConfig::FRONTEND_BUNDLE_1)->first();
    if($Bundlesubscription1 || $Bundlesubscription2){
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

    if($user->account_type == 'whitelabel' || $user->account_type == 'agency'){
        $user = User::where('id', $user->admin_id)->first();
    }

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

    $Bundlesubscription1 = SubscriptionModel::where('user_id', $userId)
        ->where('name', PaymentConfig::FRONTEND_BUNDLE_1)->first();
    $Bundlesubscription2 = SubscriptionModel::where('user_id', $userId)
    ->where('name', PaymentConfig::FRONTEND_BUNDLE_1)->first();
    if($Bundlesubscription1 || $Bundlesubscription2){
        return true;
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

    if($user->account_type == 'whitelabel' || $user->account_type == 'agency'){
        $user = User::where('id', $user->admin_id)->first();
    }

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

    $Bundlesubscription1 = SubscriptionModel::where('user_id', $userId)
        ->where('name', PaymentConfig::FRONTEND_BUNDLE_1)->first();
    $Bundlesubscription2 = SubscriptionModel::where('user_id', $userId)
    ->where('name', PaymentConfig::FRONTEND_BUNDLE_1)->first();
    if($Bundlesubscription1 || $Bundlesubscription2){
        return true;
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

    if($user->account_type == 'whitelabel' || $user->account_type == 'agency'){
        $user = User::where('id', $user->admin_id)->first();
    }

    if(!$user){
        return false;
    }

    if($user->account_type == 'whitelabel' || $user->account_type == 'agency'){
        $user = User::where('id', $user->admin_id)->first();
    }

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

    return (bool) $config['has_access_to_masterpiece'];

}

function userHasAccessToMasterpieceRequests($userId){
    $user = User::where('id', $userId)->first();
    $subscription = SubscriptionModel::where('user_id', $userId)->first();

    if(!$user){
        return false;
    }

    if($user->account_type == 'whitelabel' || $user->account_type == 'agency'){
        $user = User::where('id', $user->admin_id)->first();
    }

    if(!$user){
        return false;
    }

    if($user->role == 'admin' || $user->role == 'support' || $user->role == 'reviewer'){
        return true;
    }

    $Bundlesubscription1 = SubscriptionModel::where('user_id', $userId)
        ->where('name', PaymentConfig::FRONTEND_BUNDLE_1)->first();
    $Bundlesubscription2 = SubscriptionModel::where('user_id', $userId)
    ->where('name', PaymentConfig::FRONTEND_BUNDLE_1)->first();
    if($Bundlesubscription1 || $Bundlesubscription2){
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

    if($user->account_type == 'whitelabel' || $user->account_type == 'agency'){
        $user = User::where('id', $user->admin_id)->first();
    }

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

    $Bundlesubscription1 = SubscriptionModel::where('user_id', $userId)
        ->where('name', PaymentConfig::FRONTEND_BUNDLE_1)->first();
    $Bundlesubscription2 = SubscriptionModel::where('user_id', $userId)
    ->where('name', PaymentConfig::FRONTEND_BUNDLE_1)->first();
    if($Bundlesubscription1 || $Bundlesubscription2){
        return 999999999999;
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

    if($user->account_type == 'whitelabel' || $user->account_type == 'agency'){
        $user = User::where('id', $user->admin_id)->first();
    }

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

    $Bundlesubscription1 = SubscriptionModel::where('user_id', $userId)
        ->where('name', PaymentConfig::FRONTEND_BUNDLE_1)->first();
    $Bundlesubscription2 = SubscriptionModel::where('user_id', $userId)
    ->where('name', PaymentConfig::FRONTEND_BUNDLE_1)->first();
    if($Bundlesubscription1 || $Bundlesubscription2){
        return 9999999999999;
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

    if($user->account_type == 'whitelabel' || $user->account_type == 'agency'){
        $user = User::where('id', $user->admin_id)->first();
    }

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

    $Bundlesubscription1 = SubscriptionModel::where('user_id', $userId)
        ->where('name', PaymentConfig::FRONTEND_BUNDLE_1)->first();
    $Bundlesubscription2 = SubscriptionModel::where('user_id', $userId)
    ->where('name', PaymentConfig::FRONTEND_BUNDLE_1)->first();
    if($Bundlesubscription1 || $Bundlesubscription2){
        return 999999999999999;
    }

    $subConfig = UserSubConfigModel::where('user_id',$userId)->first();
    if(!$subConfig){
        return 1;
    }

    $config = $subConfig->config;

    return $config['sum_of_languages'];

}

function getWhitelabelConfigDetails(){
    $whitelabelIsSet = false; 
    $error = false;
    $config = null;

    $homeDomain = config('app.main_domain');
    $currentDomain = request()->getHost();
    if($currentDomain != $homeDomain){
        $config = WhiteLabelConfigModel::where('domain', $currentDomain)->first();
        if($config){
            $whitelabelIsSet = true;
        }else{
            $error = true;
        }
    }
    
    $data = [
        'config' => $config,
        'error' => $error,
        'whitelabelIsSet' => $whitelabelIsSet
    ];

    return $data;
}

function addToList($user){
    postToListOne($user);
    postToListTwo($user);
}

function postToListOne($user){
    try{

        $client = new \GuzzleHttp\Client();
        $url = "https://api.convertkit.com/v3/tags/3466339/subscribe";

        $request = $client->request('POST', $url, [
            "headers" => [
                "content-type"=> "application/json"
            ],

            'json' => [
                "api_secret" => "Adnw6DALzytVuyxonnbjjmjL1hus5b4V_FuPFZaiU8U",
                "email" => $user->email,
                "first_name" => $user->name
            ]
        ]);

        $contents = $request->getBody()->getContents();

        $contents = json_decode($contents);

        return $contents;

    }catch(\Exception $error){

        $errorMessage = $error->getMessage();
        Log::info($errorMessage);

    }
}

function postToListTwo($user){
    try{

        $client = new \GuzzleHttp\Client();
        $url = "https://api.convertkit.com/v3/tags/3480125/subscribe";

        $request = $client->request('POST', $url, [
            "headers" => [
                "content-type"=> "application/json"
            ],

            'json' => [
                "api_secret" => "2oQmnPjg66pVty-Ci4999hBnT-XDFpBYGsTLkBeY8wY",
                "email" => $user->email,
                "first_name" => $user->name
            ]
        ]);

        $contents = $request->getBody()->getContents();

        $contents = json_decode($contents);

        return $contents;

    }catch(\Exception $error){

        $errorMessage = $error->getMessage();
        Log::info($errorMessage);

    }
}
