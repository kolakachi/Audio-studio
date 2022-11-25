<?php

use App\Models\UserSubConfigModel;
use App\Helpers\PaymentConfig;
use App\Models\User;

function getDefaultConfig(){
    return [
        'has_access_to_ai_script_assistant' => false,
        'sum_of_languages' => 0,
        'has_access_to_pdf_script_assistant' => false,
        'has_access_to_word_script_assistant' => false,
        'has_access_to_text_script_assistant' => false,
        'sum_of_audio_effects' => 0,
        'sum_of_audio_output_format' => 0,
        'sum_of_stock_background_music' => 0,
        'sum_of_stock_background_sound' => 0,
        'has_access_to_upload_background_music' => false,
        'sum_of_layers' => 0,
        'length_of_audio' => 0,
        'has_access_to_timeline' => false,
        'has_access_to_social_media_share_gate' => false,
        'has_access_to_audio_embed' => false,
        'has_access_to_audio_trimmer' => false,
        'has_access_to_agency' => false,
        'has_access_to_whitelabel' => false,
        'has_access_to_reseller' => false, 
        'user_accounts' => 0,
        'has_access_to_recorder' => false, 
        'has_access_to_teleprompter' => false,
        'has_access_to_masterpiece' => false, 
        'masterpiece_request' => 0,
        'has_access_to_job_finder' => false,
        'has_access_to_agency' => false,
        'masterpiece_request' => 0,
        'masterpiece_requests_remaining' => 0,
        'masterpiece_duration' => strtotime("now")
    ];
}

function updateUserSubConfig($user, $type, $numberOfUserAccounts = 50){
    $subConfig = UserSubConfigModel::firstOrNew(['user_id' => $user->id]);
    if ($subConfig->id){
        $config = $subConfig->config;
    }else{
        $config = getDefaultConfig();
    }

    if(PaymentConfig::FRONTEND == $type){
        $updatedConfig = registerUserFrontendSub($config);
    }elseif (PaymentConfig::OTO_PLATINUM == $type) {
        $updatedConfig = registerUserPlatinumSub($config);
    }elseif (PaymentConfig::OTO_UNLIMITED_OR_BUSINESS == $type) {
        $updatedConfig = registerUserUnlimitedSub($config);
    }elseif (PaymentConfig::OTO_ENTERPRISE == $type) {
        $updatedConfig = registerUserEnterpriseSub($config);
    }elseif (PaymentConfig::OTO_WHITELABEL_AND_RESELLER == $type) {
        $updatedConfig = registerUserWhitelabelAndResellerSub($config, 50);
    }elseif (PaymentConfig::OTO_WHITELABEL_AND_RESELLER_2 == $type) {
        $updatedConfig = registerUserWhitelabelAndResellerSub($config, 250);
    }elseif (PaymentConfig::FRONTEND_BUNDLE_1 == $type) {
        $updatedConfig = registerUserFrontendBundleSub($config);
    }elseif (PaymentConfig::FRONTEND_BUNDLE_2 == $type) {
        $updatedConfig = registerUserFrontendBundleSub($config);
    }

    $subConfig->config = $updatedConfig;
    $subConfig->save();
    
}

function registerUserFrontendSub($config){
    $updatedConfig = $config;
    $updatedConfig['has_access_to_ai_script_assistant'] = true;
    $updatedConfig['sum_of_languages'] += 15;
    $updatedConfig['has_access_to_pdf_script_assistant'] = true;
    $updatedConfig['has_access_to_word_script_assistant'] = true;
    $updatedConfig['has_access_to_text_script_assistant'] = true;
    $updatedConfig['sum_of_audio_effects'] += 5;
    $updatedConfig['sum_of_audio_output_format'] += 1;
    $updatedConfig['sum_of_stock_background_music'] += 1000;
    $updatedConfig['sum_of_stock_background_sound'] += 200;
    $updatedConfig['has_access_to_upload_background_music'] = true;
    $updatedConfig['sum_of_layers'] += 2;
    $updatedConfig['length_of_audio'] += 5;
    $updatedConfig['has_access_to_timeline'] = true;
    $updatedConfig['has_access_to_social_media_share_gate'] = true;
    $updatedConfig['has_access_to_audio_embed'] = true;
    $updatedConfig['has_access_to_audio_trimmer'] = true;

    return $updatedConfig;
}

function registerUserFrontendBundleSub($config){
    $updatedConfig = $config;
    $updatedConfig['has_access_to_ai_script_assistant'] = true;
    $updatedConfig['sum_of_languages'] += 9999999999;
    $updatedConfig['has_access_to_pdf_script_assistant'] = true;
    $updatedConfig['has_access_to_word_script_assistant'] = true;
    $updatedConfig['has_access_to_text_script_assistant'] = true;
    $updatedConfig['sum_of_audio_effects'] += 99999999;
    $updatedConfig['sum_of_audio_output_format'] += 5;
    $updatedConfig['sum_of_stock_background_music'] += 9999999;
    $updatedConfig['sum_of_stock_background_sound'] += 9999999;
    $updatedConfig['has_access_to_upload_background_music'] = true;
    $updatedConfig['sum_of_layers'] += 999999999;
    $updatedConfig['length_of_audio'] += 99999999;
    $updatedConfig['has_access_to_timeline'] = true;
    $updatedConfig['has_access_to_social_media_share_gate'] = true;
    $updatedConfig['has_access_to_audio_embed'] = true;
    $updatedConfig['has_access_to_audio_trimmer'] = true;
    $updatedConfig['has_access_to_recorder'] = true; 
    $updatedConfig['has_access_to_teleprompter'] = true;
    $updatedConfig['has_access_to_masterpiece'] = true;
    $updatedConfig['masterpiece_request'] += 99999;
    $updatedConfig['has_access_to_agency'] = true;
    $updatedConfig['has_access_to_job_finder'] = true;
    $updatedConfig['masterpiece_requests_remaining'] += 999999;
    $updatedConfig['has_access_to_reseller'] = true;
    $updatedConfig['user_accounts'] += 200;
    $updatedConfig['masterpiece_duration'] = strtotime("+10 month");

    return $updatedConfig;
}

function registerUserPlatinumSub($config){
    $updatedConfig = $config;
    $updatedConfig['sum_of_languages'] += 45;
    $updatedConfig['sum_of_audio_output_format'] += 2;
    $updatedConfig['sum_of_layers'] += 2;
    $updatedConfig['sum_of_stock_background_music'] += 4000;
    $updatedConfig['sum_of_stock_background_sound'] += 300;
    $updatedConfig['has_access_to_recorder'] = true; 
    $updatedConfig['has_access_to_teleprompter'] = true;
    $updatedConfig['has_access_to_masterpiece'] = true;
    $updatedConfig['masterpiece_request'] += 100;

    $updatedConfig['masterpiece_requests_remaining'] += 100;
    $updatedConfig['masterpiece_duration'] = strtotime("+1 month");

    return $updatedConfig;
}

function registerUserUnlimitedSub($config){
    $updatedConfig = $config;
    $updatedConfig['has_access_to_ai_script_assistant'] = true;
    $updatedConfig['sum_of_languages'] += 99999999;
    $updatedConfig['has_access_to_pdf_script_assistant'] = true;
    $updatedConfig['has_access_to_word_script_assistant'] = true;
    $updatedConfig['has_access_to_text_script_assistant'] = true;
    $updatedConfig['sum_of_audio_effects'] += 999999;
    $updatedConfig['sum_of_audio_output_format'] += 5;
    $updatedConfig['sum_of_stock_background_music'] += 99999;
    $updatedConfig['sum_of_stock_background_sound'] += 99999;
    $updatedConfig['has_access_to_upload_background_music'] = true;
    $updatedConfig['sum_of_layers'] += 99999;
    $updatedConfig['length_of_audio'] += 999999;
    $updatedConfig['has_access_to_timeline'] = true;
    $updatedConfig['has_access_to_social_media_share_gate'] = true;
    $updatedConfig['has_access_to_audio_embed'] = true;
    $updatedConfig['has_access_to_audio_trimmer'] = true;
    $updatedConfig['has_access_to_recorder'] = true; 
    $updatedConfig['has_access_to_teleprompter'] = true;
    $updatedConfig['has_access_to_masterpiece'] = true;
    $updatedConfig['masterpiece_request'] += 99999;
    $updatedConfig['masterpiece_requests_remaining'] += 99999999999999;
    $updatedConfig['masterpiece_duration'] = strtotime("+100 month");

    return $updatedConfig;
}

function registerUserEnterpriseSub($config){
    $updatedConfig = $config;
    $updatedConfig['has_access_to_agency'] = true;
    $updatedConfig['has_access_to_job_finder'] = true;

    return $updatedConfig;
}

function registerUserWhitelabelAndResellerSub($config, $amount){
    $updatedConfig = $config;
    $updatedConfig['has_access_to_reseller'] = true;
    $updatedConfig['user_accounts'] += $amount;

    return $updatedConfig;
}

function resetUserSubConfig($user, $type, $numberOfUserAccounts = 50){
    $subConfig = UserSubConfigModel::firstOrNew(['user_id' => $user->id]);
    if ($subConfig->id){
        $config = $subConfig->config;
    }else{
        $config = getDefaultConfig();
    }

    if(PaymentConfig::FRONTEND == $type){
        $updatedConfig = refundUserFrontEndSub();
    }elseif (PaymentConfig::OTO_PLATINUM == $type) {
        $updatedConfig = refundUserPlatinumSub($config);
    }elseif (PaymentConfig::OTO_UNLIMITED_OR_BUSINESS == $type) {
        $updatedConfig = refundUserUnlimitedSub($config);
    }elseif (PaymentConfig::OTO_ENTERPRISE == $type) {
        $updatedConfig = refundUserEnterpriseSub($config);
    }elseif (PaymentConfig::OTO_WHITELABEL_AND_RESELLER == $type) {
        $updatedConfig = refundUserWhiteLabelProSub($config, 50);
    }elseif (PaymentConfig::OTO_WHITELABEL_AND_RESELLER_2 == $type) {
        $updatedConfig = refundUserWhiteLabelProSub($config, 150);
    }elseif (PaymentConfig::FRONTEND_BUNDLE_1 == $type) {
        $updatedConfig = refundUserFrontendBundleSub($config);
    }elseif (PaymentConfig::FRONTEND_BUNDLE_2 == $type) {
        $updatedConfig = refundUserFrontendBundleSub($config);
    }

    $subConfig->config = $updatedConfig;
    $subConfig->save();
}

function refundUserFrontEndSub(){
    $updatedConfig = getDefaultConfig();
    return $updatedConfig;
}

function refundUserPlatinumSub($config){    
    $updatedConfig = $config;
    $updatedConfig['sum_of_languages'] -= 45;
    $updatedConfig['sum_of_audio_output_format'] -= 2;
    $updatedConfig['sum_of_layers'] -= 2;
    $updatedConfig['sum_of_stock_background_music'] -= 4000;
    $updatedConfig['sum_of_stock_background_sound'] -= 300;
    $updatedConfig['has_access_to_recorder'] = false; 
    $updatedConfig['has_access_to_teleprompter'] = false;
    $updatedConfig['has_access_to_masterpiece'] = false;
    $updatedConfig['masterpiece_request'] -= 100;
    $updatedConfig['masterpiece_requests_remaining'] -= 100;
    $updatedConfig['masterpiece_duration'] = strtotime("now");

    return $updatedConfig;
}

function refundUserUnlimitedSub($config){
    $updatedConfig = $config;
    $updatedConfig['has_access_to_ai_script_assistant'] = false;
    $updatedConfig['sum_of_languages'] -= 99999999;
    $updatedConfig['has_access_to_pdf_script_assistant'] = false;
    $updatedConfig['has_access_to_word_script_assistant'] = false;
    $updatedConfig['has_access_to_text_script_assistant'] = false;
    $updatedConfig['sum_of_audio_effects'] -= 999999;
    $updatedConfig['sum_of_audio_output_format'] -= 5;
    $updatedConfig['sum_of_stock_background_music'] -= 99999;
    $updatedConfig['sum_of_stock_background_sound'] -= 99999;
    $updatedConfig['has_access_to_upload_background_music'] = false;
    $updatedConfig['sum_of_layers'] -= 99999;
    $updatedConfig['length_of_audio'] -= 999999;
    $updatedConfig['has_access_to_timeline'] = false;
    $updatedConfig['has_access_to_social_media_share_gate'] = false;
    $updatedConfig['has_access_to_audio_embed'] = false;
    $updatedConfig['has_access_to_audio_trimmer'] = false;
    $updatedConfig['has_access_to_recorder'] = false; 
    $updatedConfig['has_access_to_teleprompter'] = false;
    $updatedConfig['has_access_to_masterpiece'] = false;
    $updatedConfig['masterpiece_request'] -= 99999;
    $updatedConfig['masterpiece_requests_remaining'] -= 99999999999999;
    $updatedConfig['masterpiece_duration'] = strtotime("now");

    return $updatedConfig;
}

function refundUserEnterpriseSub($config){
    $updatedConfig = $config;
    $updatedConfig['has_access_to_agency'] = false;
    $updatedConfig['has_access_to_job_finder'] = false;

    return $updatedConfig;
}

function refundUserWhiteLabelProSub($config, $numberOfUserAccounts = 50){
    $updatedConfig = $config;
    $updatedConfig['has_access_to_reseller'] = true;
    $updatedConfig['user_accounts'] -= $numberOfUserAccounts;

    return $updatedConfig;
}

function refundUserFrontendBundleSub($config){
    $updatedConfig = $config;
    $updatedConfig['has_access_to_ai_script_assistant'] = false;
    $updatedConfig['sum_of_languages'] -= 9999999999;
    $updatedConfig['has_access_to_pdf_script_assistant'] = false;
    $updatedConfig['has_access_to_word_script_assistant'] = false;
    $updatedConfig['has_access_to_text_script_assistant'] = false;
    $updatedConfig['sum_of_audio_effects'] -= 99999999;
    $updatedConfig['sum_of_audio_output_format'] -= 5;
    $updatedConfig['sum_of_stock_background_music'] -= 9999999;
    $updatedConfig['sum_of_stock_background_sound'] -= 9999999;
    $updatedConfig['has_access_to_upload_background_music'] = false;
    $updatedConfig['sum_of_layers'] -= 999999999;
    $updatedConfig['length_of_audio'] -= 99999999;
    $updatedConfig['has_access_to_timeline'] = false;
    $updatedConfig['has_access_to_social_media_share_gate'] = false;
    $updatedConfig['has_access_to_audio_embed'] = false;
    $updatedConfig['has_access_to_audio_trimmer'] = false;
    $updatedConfig['has_access_to_recorder'] = false; 
    $updatedConfig['has_access_to_teleprompter'] = false;
    $updatedConfig['has_access_to_masterpiece'] = false;
    $updatedConfig['masterpiece_request'] -= 99999;
    $updatedConfig['has_access_to_agency'] = false;
    $updatedConfig['has_access_to_job_finder'] = false;
    $updatedConfig['masterpiece_requests_remaining'] -= 999999;
    $updatedConfig['has_access_to_reseller'] = false;
    $updatedConfig['user_accounts'] -= 200;
    $updatedConfig['masterpiece_duration'] = strtotime("now");

    return $updatedConfig;
}

function getUserSubConfig($userId){
    $user = User::where('id', $userId)->first();

    if(!$user){
        return getDefaultConfig();
    }
    $subConfig = UserSubConfigModel::where('user_id',$user->id)->first();
    if ($subConfig){
        $config = $subConfig->config;
    }else{
        $config = getDefaultConfig();
    }

    return $config;
}

