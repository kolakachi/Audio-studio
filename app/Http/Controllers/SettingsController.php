<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Auth, Log, Exception;

class SettingsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('subscription');
    }

    public function index(){
        $page = "settings";
        $data = [
            'page' => $page,
            'pageClass' => 'whitelabel-page'
        ];
        return view('app.settings.index', $data);
    }

    public function updateDetails(Request $request){
        try{
            $user = Auth::user();
            $user->name = $request->name;
            $user->save();

            $message = "Details updated";
            return response()->json([
                'message' => $message,
            ]);

        }catch(Exception $error){
            Log::info('SettingsController@updateDetails error message: ' . $error->getMessage());
            $message = "Unable to complete request.";
            return response()->json(['message' => $message], 500);
        }
    }

    public function updatePassword(Request $request){
        try{

            if($request->password != $request->confirm_password || $request->password == ""){
                return response()->json([
                    'status' => 'error',
                    'message' => "Password is required. Password and confirm password must match."
                ], 400);
            }

            $user = Auth::user();
            $user->password = bcrypt($request->password);
            $user->save();

            $message = "Password updated";
            return response()->json([
                'message' => $message,
            ]);

        }catch(Exception $error){
            Log::info('SettingsController@updatePassword error message: ' . $error->getMessage());
            $message = "Unable to complete request.";
            return response()->json(['message' => $message], 500);
        }
    }
}
