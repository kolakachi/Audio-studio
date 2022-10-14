<?php

namespace App\Http\Controllers;

use DB, Session, Auth;
use App\Helpers\Paths;
use App\Models\AudioBookModel;
use App\Models\AudioModel;
use Illuminate\Http\Request;

class EditorController extends Controller
{
    public function index(Request $request, $uuid)
    {  
        # Set Voice Types as Listed in TTS Config
        if (config('tts.voice_type') == 'standard') {
            $languages = DB::table('voices')
                ->join('vendors', 'voices.vendor_id', '=', 'vendors.vendor_id')
                ->join('languages', 'voices.language_code', '=', 'languages.language_code')
                ->where('vendors.enabled', '1')
                ->where('voices.voice_type', 'standard')
                ->select('languages.id', 'languages.language', 'voices.language_code', 'languages.language_flag')                
                ->distinct()
                ->orderBy('languages.id', 'asc')
                ->get();

            $voices = DB::table('voices')
                ->join('vendors', 'voices.vendor_id', '=', 'vendors.vendor_id')
                ->where('vendors.enabled', '1')
                ->where('voices.voice_type', 'standard')
                ->get();

        } elseif (config('tts.voice_type') == 'neural') {
            $languages = DB::table('voices')
                ->join('vendors', 'voices.vendor_id', '=', 'vendors.vendor_id')
                ->join('languages', 'voices.language_code', '=', 'languages.language_code')
                ->where('vendors.enabled', '1')
                ->where('voices.voice_type', 'neural')
                ->select('languages.id', 'languages.language', 'voices.language_code', 'languages.language_flag')                
                ->distinct()
                ->orderBy('languages.id', 'asc')
                ->get();

            $voices = DB::table('voices')
                ->join('vendors', 'voices.vendor_id', '=', 'vendors.vendor_id')
                ->where('vendors.enabled', '1')
                ->where('voices.voice_type', 'neural')
                ->get();

        } else {
            $languages = DB::table('voices')
                ->join('vendors', 'voices.vendor_id', '=', 'vendors.vendor_id')
                ->join('languages', 'voices.language_code', '=', 'languages.language_code')
                ->where('vendors.enabled', '1')
                ->select('languages.id', 'languages.language', 'voices.language_code', 'languages.language_flag')                
                ->distinct()
                ->orderBy('languages.id', 'asc')
                ->get();

            $voices = DB::table('voices')
                ->join('vendors', 'voices.vendor_id', '=', 'vendors.vendor_id')
                ->where('vendors.enabled', '1')
                ->get();
        }

        $userText = "";
        if(Session::has('user_text')){
            $userText = Session::get('user_text');
        }

        
        # Max Chars for Textarea and Textarea Counter
        $max_chars = config('tts.max_chars_limit');
        $config = config('settings.vendor_logos');

        $audio = AudioBookModel::where('uuid', $uuid)->first();
        if(!$audio){
            abort(404, "Audio not found");
        }

        $page = 'editor';
        $pageClass = 'audio-editor-page';
        if(getNumberOfLanguages(Auth::id()) < 16){
            $languages = $this->filterLanguages($languages);
        }
        $userAccess = [
            'number_of_audio_output' => getNumberOfAudioOutput(Auth::id()),
            'number_of_layers' => getNumberOfLayers(Auth::id()),
            'has_access_to_recorder' => userHasAccessToRecorder(Auth::id()),
            'has_access_to_teleprompter' => userHasAccessToTeleprompter(Auth::id()),
            'has_access_to_masterpiece' => userHasAccessToMasterpiece(Auth::id()),
        ];

        return view('app.editor.index', compact('languages', 'voices', 'max_chars', 'config', 'userText', 'audio', 'page', 'pageClass', 'userAccess'));
    }

    private function filterLanguages($languages){
        $filteredLanguages = [];
        $allowedLanguages = [
            'English (USA)',
	        'English (UK)',
	        'English (Canada)',
	        'French (France)',
	        'German (Germany)',
	        'Italian (Italy)',
	        'Spanish (Spain)',
	        'Arabic (Saudi Arabia)',
	        'Greek (Greece)',
	        'Hindi (India)',
	        'Portuguese (Portugal)',
	        'Russian (Russia)',
	        'Chinese (Cantonese)',
	        'Dutch (Belgium)',
	        'Turkish (Turkey)'
        ];
        foreach($languages as $language){
            if(in_array($language->language, $allowedLanguages)){
                $filteredLanguages[] = $language;
            }
        }

        return $filteredLanguages;
    }

}
