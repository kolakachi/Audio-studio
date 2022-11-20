<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\User;
use App\Models\SubscriptionAddonModel;
use App\Models\SubscriptionModel;
use Auth, Validator, Mail, Log, Redirect, Session, Storage, File;

class SuperUserController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin');
    }

    public function users(){
        $users = User::all()->take(5);
        $data = [
            'page' => 'admin',
            'pageClass' => 'admin-page',
            'users' => $users,
        ];
        return view('app.admin.users',$data);
    }

    public function impersonateUser($userId = ""){
        $user = User::where('id', $userId)->first();
        if($user){
            Session::put('active_admin_id', Auth::id());
            Auth::loginUsingId($userId);
            return redirect()->route('user.booster.index');
        }
       abort(404);
    }

    public function userSearch(Request $request){
        try{
            $users = User::where('email', "LIKE", "%" . $request->search_query . "%")
                ->orWhere("name", "LIKE", "%" . $request->search_query . "%")
                ->get();
            if($request->search_query == ''){
                $users =[];
            }
            return response()->json([
                // 'message' => "Search.",
                'users' => $users
            ]);
        }catch(Exception $error){
            Log::info('UserController@add error message: ' .$error->getMessage());
            $message = "Unable to complete request.";
            return response()->json(['message' => $message], 500);
        }
    }
    public function add(Request $request){
        try{
            $validator = $this->validator($request->all());
            if($validator->fails()){
                return response()->json([
                    'message' => "Unable to complete request",
                    "errors" => $validator->errors()
                ], 400);
            }
            if(Auth::user()->role != 'admin'){
                return response()->json([
                    'status' => 'error',
                    'message' => "You do not have enough permissions to complete request."
                ], 400);
            }

            if($request->password != $request->confirm_password || $request->password == ""){
                return response()->json([
                    'status' => 'error',
                    'message' => "Password is required. Password and confirm password must match."
                ], 400);
            }

            $user = new User;
            $user->name = $request->first_name .' '. $request->last_name;
            $user->email = $request->email;
            $user->role = $request->role;
            $user->uuid = \Str::uuid();

            $user->password = bcrypt($request->password);
            $user->is_active = true;
            $user->added_by = Auth::id();
            $user->save();
            if($user->role == 'member'){
                addToList($user);
            }
            
            // $this->createWorkspace($user);
            $this->setSubscription($request, $user);


            return response()->json([
                'message' => "User Added.",
                'user' => $user
            ]);



        }catch(Exception $error){
            Log::info('UserController@add error message: ' .$error->getMessage());
            $message = "Unable to complete request.";
            return response()->json(['message' => $message], 500);
        }
    }


    public function delete(Request $request){
        try {
            if ($request->id == '') {
                $message = "User ID is required";
                return response()->json(['message' => $message], 400);
            }
            $user = User::where('id', $request->id)->first();
            if (!$user) {
                $message = "User was not found";
                return response()->json(['message' => $message], 404);
            }
            if(Auth::user()->role != 'admin'){
                return response()->json([
                    'status' => 'error',
                    'message' => "You do not have enough permissions to complete request."
                ], 400);
            }
            $user->delete();
            $message = "User deleted successfully";
            return response()->json(['message' => $message]);
        } catch (Exception $error) {
            Log::info('UserController@delete error message: ' . $error->getMessage());
            $message = "Unable to complete request.";
            return response()->json(['message' => $message], 500);
        }
    }

    public function update(Request $request){
        try{
            $validator = $this->updateValidator($request->all(), $request->id);
            if($validator->fails()){
                return response()->json([
                    'message' => "Unable to complete request",
                    "errors" => $validator->errors()
                ], 400);
            }
            $request->user_access = json_decode($request->updated_access);
            if(Auth::user()->role != 'admin'){
                return response()->json([
                    'status' => 'error',
                    'message' => "You do not have enough permissions to complete request."
                ], 400);
            }

            $user = User::where('id', $request->id)->first();
            if(!$user){
                return response()->json([
                    'message' => "Unable to complete request. User not found",
                    "errors" => []
                ], 400);
            }
            $user->name = $request->first_name .' '. $request->last_name;
            $user->email = $request->email;
            $user->role = $request->role;
            $user->save();

            //$this->updateUserWorkSpaceAccess($user, $request);

            return response()->json([
                'message' => "User Details updated",
                'user' => $user
            ]);



        }catch(Exception $error){
            Log::info('UserController@add error message: ' .$error->getMessage());
            $message = "Unable to complete request.";
            return response()->json(['message' => $message], 500);
        }
    }

    public function updatePassword(Request $request){
        try{
            $user = User::where('id', $request->id)->first();
            if(!$user){
                return response()->json([
                    'message' => "Unable to complete request. User not found",
                    "errors" => []
                ], 400);
            }

            if($request->password != $request->confirm_password || $request->password == ""){
                return response()->json([
                    'status' => 'error',
                    'message' => "Password is required. Password and confirm password must match."
                ], 400);
            }
            $user->password = bcrypt($request->password);
            $user->save();
            //$this->updateUserWorkSpaceAccess($user, $request);

            return response()->json([
                'message' => "User Details updated",
                'user' => $user
            ]);



        }catch(Exception $error){
            Log::info('UserController@updatePassword error message: ' .$error->getMessage());
            $message = "Unable to complete request.";
            return response()->json(['message' => $message], 500);
        }
    }

    public function updateSub(Request $request){
        try{
            $user = User::where('id', $request->id)->first();
            if(!$user){
                return response()->json([
                    'message' => "Unable to complete request. User not found",
                    "errors" => []
                ], 400);
            }
           $this->setSubscription($request, $user);

            return response()->json([
                'message' => "User Details updated",
                'user' => $user
            ]);



        }catch(Exception $error){
            Log::info('UserController@updatePassword error message: ' .$error->getMessage());
            $message = "Unable to complete request.";
            return response()->json(['message' => $message], 500);
        }
    }
    
    private function setSubscription($request, $user){
        $subscriptions = (array)json_decode($request->subscriptions);
        $subId = 0;
        foreach($subscriptions as $key => $value){
            $value = (array) $value;
            $status = (isset($value['status']))? $value['status'] == 'true' : false; 
            if($key == 'front_end_bundle_1'){
                $subscription = SubscriptionModel::firstOrNew([
                    'user_id' => $user->id, 
                ]);
                $subscription->name = $key;
                
                if (!$subscription->created_at && $status){
                    updateUserSubConfig($user, $key);
                }elseif (!$status && $subscription->created_at) {
                    resetUserSubConfig($user, $key);
                }elseif ($status && !$subscription->status) {
                    updateUserSubConfig($user, $key);
                }

                $subscription->status = $status;
                $subscription->save();
                
                // $subId = $subscription->id; 
                
            }

            if($key == 'front_end_bundle_2'){
                $subscription = SubscriptionModel::firstOrNew([
                    'user_id' => $user->id, 
                ]);
                $subscription->name = $key;
                
                if (!$subscription->created_at && $status){
                    updateUserSubConfig($user, $key);
                }elseif (!$status && $subscription->created_at) {
                    resetUserSubConfig($user, $key);
                }elseif ($status && !$subscription->status) {
                    updateUserSubConfig($user, $key);
                }

                $subscription->status = $status;
                $subscription->save();
                
            }

        }
    }

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'first_name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'role' => 'required',
        ]);
    }

    protected function updateValidator(array $data, $userId)
    {
        return Validator::make($data, [
            'first_name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,'.$userId,
            'role' => 'required',
        ]);
    }

    private function errorWithErrorMessage($error){

        $message = "Encountered an error. Please try again.";
        Session::put('errorMessage', $message);
        return redirect()->back();
    }
}
