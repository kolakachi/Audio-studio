<?php

namespace App\Http\Controllers;

use App\Models\AudioBookModel;
use Illuminate\Http\Request;

class ShareController extends Controller
{
    public function index($audioUUID){
        try{
            $audio = AudioBookModel::where('uuid', $audioUUID)->first();
            if(!$audio){
                $message = 'Unable to get Resource. Audio not found.';
                abort(404, $message);
            }
            $noControls = (request()->no_controls == null)? 0 : request()->no_controls;
            $autoplay = (request()->autoplay == null)? 0 : request()->autoplay;

            $data = [
                'audio' => $audio,
                'autoplay' => $autoplay,
                'noControls' => $noControls
            ];
            return view('app.share.index', $data);

        }catch(\Exception $error){
            \Log::info('ShareController@index error message: ' . $error->getMessage());
            $message = 'Unable to get Resource. Encountered an error.';
            
            abort(500, $message);
        }
    }
}
