<?php

namespace App\Http\Controllers;

use Exception, Log;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(){
        return view('app.dashboard.index');

    }

    public function uploadText(Request $request){
        try {
            $text = $request->text;
            \Session::put('user_text', $text);
            $url = route('user.update-tts');
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
}
