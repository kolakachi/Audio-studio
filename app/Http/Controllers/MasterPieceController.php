<?php

namespace App\Http\Controllers;

use App\Helpers\Keys;
use Illuminate\Http\Request;

class MasterPieceController extends Controller
{
    // public function __construct()
    // {
    //     $this->middleware('auth');
    // }

    public function updateText(Request $request){
        $response = $this->getOpenAIMasterPieceResult($request);
        return response()->json([
            'message' => 'Generated',
            'status' => 'Success',
            'text' => $response,
        ]);
    }

    public function getOpenAIMasterPieceResult($request){
        $client = new \GuzzleHttp\Client();
        $url = "https://api.openai.com/v1/engines/text-davinci-002/completions";
        $temperature = 1;
        $prompt = $this->getMasterPiecePrompt($request);
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
            ], 
    
        ]);
        $contents = $res->getBody()->getContents();
        $contents = json_decode($contents);
        $result = $contents->choices[0]->text;

        return $result;
        
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
