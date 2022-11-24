<?php

namespace App\Http\Controllers;

use Auth, Log;
use App\Helpers\Keys;
use Illuminate\Http\Request;

class MasterPieceController extends Controller
{
    // public function __construct()
    // {
    //     $this->middleware('auth');
    // }

    public function updateText(Request $request){
        try{
            if(!userHasAccessToMasterpieceRequests(Auth::id())){
                $message = "You do not have enough credits to make this request";
                return response()->json(['message' => $message], 401);
            }
            $response = $this->getOpenAIMasterPieceResult($request);
            if($response['error']){
                return response()->json([
                    'message' => $response['message'],
                    'status' => 'Failed',
                    'text' => '',
                ], 400);
            }
            $text = $response['text'];
            return response()->json([
                'message' => 'Generated',
                'status' => 'Success',
                'text' => $text,
            ]);
        }catch(\Exception $error){
            Log::info('MasterPieceController@updateText error message: ' . $error->getMessage());
            $message = "Unable to complete request.";
            return response()->json(['message' => $message], 500);
        }
    }

    public function getOpenAIMasterPieceResult($request){
        $client = new \GuzzleHttp\Client();
        $url = "https://api.openai.com/v1/engines/text-davinci-002/completions";
        $temperature = 1;
        $prompt = $this->getMasterPiecePrompt($request);
        if($this->contentModerationisFlagged($prompt)){
            return [
                'error' => true,
                'choices' => [],
                'message' => 'Request was found promoting sexual, hateful, violent, or self-harm content. Please try again with a different content.'
            ];
        }
        $res = $client->request('POST', $url, [
            'headers' => [
                'Content-Type' => 'application/json',
                'Authorization' => 'Bearer ' . Keys::OPEN_AI_KEY,
            ],
            'json' => [
                'prompt' => $prompt,
                'temperature' => $temperature,
                'max_tokens' => 1000,
                'frequency_penalty' => 0,
                'presence_penalty' => 0,
                "user"=> 'user'.Auth::id()
            ], 
    
        ]);
        $contents = $res->getBody()->getContents();
        $contents = json_decode($contents);
        $result = $contents->choices[0]->text;
        return [
            'error' => false,
            'text' => $result
        ];
        return $result;
        
    }

    private function contentModerationisFlagged($text){
        $body = [
            'input' => $text,
        ];

        $client = new \GuzzleHttp\Client();
        $url ='https://api.openai.com/v1/moderations';
        $res = $client->request('POST', $url, [
            'headers' => [
                'Content-Type' => 'application/json',
                'Authorization' => 'Bearer ' . Keys::OPEN_AI_KEY,
            ],
            'json' => $body,
        ]);
        $contents = $res->getBody()->getContents();
        $response = json_decode($contents);
        return $response->results[0]->flagged;
    }

    private function getMasterPiecePrompt(Request $request)
    {
        $language = $request->language != 'english' ? " Translate the result to $request->language." : '';
        $topic = $request->selected_text ?? '';

        switch ($request->type) {
            case 'improve_text':
                
                return <<<PROMPT
                    Write a creative summary about the following topic $language:
                    
                    Topic: $topic
                PROMPT;
                break;
            case 'rephrase_text':

                return <<<PROMPT
                    Rephrase the following text $language
                    
                    Text: $topic
                PROMPT;
                break;
            case 'expand_text':
                
                return <<<PROMPT
                    Write about the following topic $language:
                    
                    Topic: $topic
                    
                PROMPT;
                break;
            case 'shorten_text':

                return <<<PROMPT
                    make the following text very short $language
                        
                    Text: $topic
                
                PROMPT;
                break;
            
            default:
                throw new RuntimeErrorException('Context not implemented');
        }
    }
}
