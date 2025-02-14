<?php

namespace App\Services;

use App\Helpers\Paths;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use App\Services\Statistics\UserService;
use App\Models\Voice;

class AzureTTSService 
{
    private $azureKey;
    private $azureRegion;
    private $api;
    

    public function __construct()
    {
        $this->api = new UserService();
        $this->azureKey = config('services.azure.key');         
        $this->azureRegion = config('services.azure.region');                   
    }


    /**
     * Synthesize text via Azure text to speech 
     *
     * 
     */
    public function synthesizeSpeech(Voice $voice, $text, $format, $file_name)
    {
        if ($this->api->api_url != 'https://license.berkine.space/') {
            return;
        }
        $azureResponse = $this->getAzureAccessToken();
        if($azureResponse['error']){
            return;
        }
        $accessToken = $azureResponse['content'];
        $azureEndpoint = 'https://'.$this->azureRegion.'.tts.speech.microsoft.com/cognitiveservices/v1';

        if ($format == 'mp3') {
            $output_format = 'audio-24khz-48kbitrate-mono-mp3';
        } elseif ($format == 'ogg') {
            $output_format = 'ogg-24khz-16bit-mono-opus';
        } elseif ($format == 'webm') {
            $output_format = 'webm-24khz-16bit-mono-opus';
        }

        $text = preg_replace("/\&/", "&amp;", $text);
        $text = preg_replace("/(^|(?<=\s))<((?=\s)|$)/i", "&lt;", $text);
        $text = preg_replace("/(^|(?<=\s))>((?=\s)|$)/i", "&gt;", $text);

        $ssml_text = '<speak version="1.0" xmlns="http://www.w3.org/2001/10/synthesis" xmlns:mstts="http://www.w3.org/2001/mstts" xmlns:emo="http://www.w3.org/2009/10/emotionml" xml:lang="' . $voice->language_code . '"><voice name="' . $voice->voice_id . '">' . $text . '</voice></speak>';

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $azureEndpoint);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            // 'Authorization: Bearer '. $accessToken,
            'Ocp-Apim-Subscription-Key: ' . $this->azureKey,
            'Content-Type: application/ssml+xml',
            'X-Microsoft-OutputFormat:' . $output_format,
            'User-Agent: Berkin',
        ]);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $ssml_text);

        $audio_stream = curl_exec($ch);

        if (curl_errno($ch)) {
            return response()->json(["error" => "Azure Synthesize Error. Please notify support team."], 422);
            Log::error(curl_error($ch) . ' ' . $audio_stream);
        }
        curl_close($ch);
        Storage::disk('audio')->put("test.wav", $audio_stream); 
        $file_name = Paths::SPEECH_PATH. $file_name;
        if (config('tts.default_storage') === 's3') {
            Storage::disk('s3')->put('azure/' . $file_name, $audio_stream);
            $result = Storage::disk('s3')->url('azure/' . $file_name);    
        } elseif (config('tts.default_storage') == 'wasabi') {
            Storage::disk('wasabi')->put('azure/' . $file_name, $audio_stream);
            $result = Storage::disk('wasabi')->url('azure/' . $file_name);                
        } else {                
            Storage::put($file_name, $audio_stream); 
            $result = Storage::url($file_name);                
        }

        return $result;
    }

    public function getAzureAccessToken(){
        try{
            $url = "https://eastus.api.cognitive.microsoft.com/sts/v1.0/issuetoken";

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
            curl_setopt($ch, CURLOPT_HTTPHEADER, [
                'Ocp-Apim-Subscription-Key: ' . $this->azureKey,
                'Content-type: application/x-www-form-urlencoded',
                'Content-Length: 0',
                'User-Agent: curl',
                // 'Content-Type: application/ssml+xml',
                // 'X-Microsoft-OutputFormat:' . $output_format,
                // 'User-Agent: Audio-Studio',
            ]);

            $content = curl_exec($ch);
            return [
                "content" => $content,
                "error" => false
            ];

        }catch(\Exception $error){
            \Log::info($error->getMessage());
            return [
                "content" => [],
                "error" => true
            ];
        }
        
    }
}