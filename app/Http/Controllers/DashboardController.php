<?php

namespace App\Http\Controllers;

use App\Helpers\Paths;
use Exception, Log, Auth, File;
use Illuminate\Support\Facades\Storage;
use App\Models\AudioBookModel;
use App\Models\AudioModel;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except(['getAudio']);
        $this->middleware('subscription')->except(['getAudio']);
    }

    public function index(){
        $audios = AudioBookModel::where('user_id', Auth::id())->orderBy('id', 'desc')->take(4)->get();
        $data = [
            'audios' => $audios,
            'page' => 'dashboard',
            'pageClass' => 'dashboard-page'

        ];
        return view('app.dashboard.index', $data);

    }

    public function newAudio(){
        $audio = new AudioBookModel();
        $audio->uuid = \Str::uuid();
        $audio->user_id = Auth::id();
        $audio->audio_name = "new-project-".time();
        $audio->speech_text = '';
        $audio->layers = [];
        $audio->save();

        return redirect()->route('user.editor.index', $audio->uuid);
    }

    public function uploadText(Request $request){
        try {
            $text = $request->text;
            \Session::put('user_text', $text);

            $audio = new AudioBookModel();
            $audio->uuid = \Str::uuid();
            $audio->user_id = Auth::id();
            $audio->speech_text = $text;
            $audio->audio_name = "new-project-".time();
            $audio->layers = [];
            $audio->save();

            $url = route('user.editor.index', $audio->uuid);
            return response()->json([
                'user_text' => $text,
                'url' => $url
            ]);
        } catch (Exception $error) {
            Log::info('DashboardController@uploadText error message: ' . $error->getMessage());
            $message = "Unable to complete request.";
            return response()->json(['message' => $message], 500);
        }
    }

    public function getAudio($audioUUID){
        $audio = AudioModel::where('uuid', $audioUUID)->first();
        if(!$audio){
            abort(404, "Audio not found");
        }
        if($audio->category == 'text_audio'){
            $file = \Storage::disk('audio')->path($audio->file_name);
        }else{
            $file = Storage::path(Paths::AUDIO_PATH. $audio->file_name);
        }


        $mime_type = "audio/mp3";
        $headers = array(
            'Accept-Ranges: bytes',
    
            'Content-Length:'.filesize($file),
            'Content-Type:' . $mime_type,
            'Content-Disposition: inline; filename="'.$audio->file_name.'"'
    
        );
        // dd($file);
        $fileContents = File::get($file);
        return response()->file($file, $headers);
        return \Response::make($fileContents, 200)->header('Content-Type', 'audio/mp3',);
        
    }

    public function downloadAudio($audioUUID){
        $audio = AudioModel::where('uuid', $audioUUID)->first();
        if(!$audio){
            abort(404, "Audio not found");
        }

        if($audio->category == 'text_audio'){
            $file = \Storage::disk('audio')->path($audio->file_name);
        }else{
            $file = Storage::path(Paths::AUDIO_PATH. $audio->file_name);
        }
        return \Response::download($file);
    }
}
