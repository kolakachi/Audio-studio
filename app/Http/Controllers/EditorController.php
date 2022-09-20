<?php

namespace App\Http\Controllers;

use DB, Session;
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


        return view('app.editor.index', compact('languages', 'voices', 'max_chars', 'config', 'userText', 'audio', 'page', 'pageClass'));
    }

}
