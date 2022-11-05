<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Helpers\Paths;
use Illuminate\Http\Request;
use Auth, Validator, Mail, File, Storage, Log, Session, Exception;

class AgencyController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('subscription');
        $this->middleware('enterprise');
    }

    public function index(){
        
        $data = [
            'page' => 'agency',
            'pageClass' => 'agency-page'

        ];
        return view('app.agency.index', $data);

    }

    public function teams(){
        $users = User::where('account_type', 'agency')->where('admin_id', Auth::id())->get();

        $data = [
            'users' => $users,
            'page' => 'agency',
            'pageClass' => 'agency-teams-page'

        ];
        return view('app.agency.teams', $data);

    }

    public function addAccount(Request $request){
        try{
            // if(!userHasAcessToWhitelabel(Auth::id())){
            //     return response()->json([
            //         'error' => true,
            //         'status_code' => 400,
            //         "message" => "Sorry, you don't have access to this feature",
            //     ], 400);
            // }

            // if(resellerCreatedAccountsRemaining(Auth::id()) < 1){
            //     return response()->json([
            //         'error' => true,
            //         'status_code' => 400,
            //         "message" => "Sorry, you have exhausted the number of accounts you can create.",
            //     ], 400);
            // }

            $validator = $this->validateUserDetails($request->all());
            if($validator->fails()){
                return response()->json([
                    'error' => true,
                    'status_code' => 400,
                    "message" => "Invalid data",
                    "errors" => $validator->messages()
                ], 400);
            }
            $user = $this->createUser($request);
            // $this->createWorkspace($user);
            // $this->setSubscription($request, $user);

            // updateResellerAccount(Auth::id());

            // $this->tokenSentToUserMail($user);


            return response()->json([
                'error' => false,
                'user' => $user,
                'message' => "User was created successfully"
            ], 200);

        }catch(Exception $error){
            Log::info('AgencyController@addAccount error message: ' . $error->getMessage());
            $message = "Unable to complete request.";
            return response()->json(['message' => $message], 500);
        }
    }

    private function createUser($request){
        $user = new User;
        $user->name = $request->first_name .' '. $request->last_name;
        $user->email = $request->email;
        $user->is_active = true;
        $user->status = 'active';
        $user->role = 'member';
        $user->assignRole('user');
        $user->uuid = \Str::uuid();
        $user->email_verified_at = now();
        $user->account_type = 'agency';
        $user->job_role = 'User';
        $user->admin_id = Auth::id();
        $user->added_by = Auth::id();
        $user->password = bcrypt($request->password);
        $user->save();

        return $user;
    }

    public function deleteAccount(Request $request){
        try{
            if($request->id == ''){
                $message = "User ID is required";
                return response()->json(['message' => $message], 400);
            }
            $user = User::where('account_type', 'agency')
                ->where('admin_id', Auth::id())
                ->where('id', $request->id)->first();
            if(!$user){
                $message = "User was not found";
                return response()->json(['message' => $message], 404);
            }
            // $sub = SubscriptionModel::where('user_id', $user->id)->first();
            // if($sub){
            //     SubscriptionAddonModel::where('subscription_id', $sub->id)->delete();
            // }
            // $sub->delete();



            $user->delete();
            // updateResellerAccount(Auth::id(), 'remove');
            // $sumOfUsers = count(User::where('account_type', 'whitelabel')->where('admin_id', Auth::id())->get());
            // $sumOfUsersToday = count(User::where('account_type', 'whitelabel')
            //     ->where('admin_id', Auth::id())
            //     ->whereDay('created_at', now()->day)->get());
            // $sumOfUsersThisWeek = count(User::where('account_type', 'whitelabel')
            //     ->where('admin_id', Auth::id())
            //     ->whereBetween('created_at',
            //     [
            //         \Carbon\Carbon::now()->startOfWeek(),
            //         \Carbon\Carbon::now()->endOfWeek()
            //     ])->get());
            
            $message = "User deleted successfully";
            return response()->json([
                'message' => $message,
            ]);

        }catch(Exception $error){
            Log::info('AgencyController@deleteAccount error message: ' . $error->getMessage());
            $message = "Unable to complete request.";
            return response()->json(['message' => $message], 500);
        }
    }

    public function updateAccount(Request $request){
        try{
            $user = User::where('account_type', 'agency')
                ->where('admin_id', Auth::id())
                ->where('id', $request->id)->first();
            if(!$user){
                return response()->json([
                    'error' => true,
                    'status_code' => 404,
                    "message" => "user not found"
                ], 404);
            }

            $validator = Validator::make($request->all(), [
                'first_name' => 'required|string|max:255',
                'email' => 'required|email|unique:users,email,'.$user->id,
                'role' => 'required',
            ]);
            if($validator->fails()){
                return response()->json([
                    'error' => true,
                    'status_code' => 400,
                    "message" => "Invalid data",
                    "errors" => $validator->messages()
                ], 400);
            }
            
            $user->name = $request->first_name .' '. $request->last_name;
            $user->email = $request->email;
            $user->role = $request->role;
            $user->save();

            return response()->json([
                'error' => false,
                'user' => $user,
                'message' => "User was updated successfully"
            ], 200);

        }catch(Exception $error){
            Log::info('AgencyController@updateAccount error message: ' . $error->getMessage());
            $message = "Unable to complete request.";
            return response()->json(['message' => $message], 500);
        }
    }

    public function updatePassword(Request $request){
        try{
            $user = User::where('account_type', 'agency')
                ->where('admin_id', Auth::id())
                ->where('id', $request->id)->first();
            if(!$user){
                return response()->json([
                    'error' => true,
                    'status_code' => 404,
                    "message" => "user not found"
                ], 404);
            }

            if($request->password != $request->confirm_password || $request->password == ""){
                return response()->json([
                    'status' => 'error',
                    'message' => "Password is required. Password and confirm password must match."
                ], 400);
            }

            $user->password = bcrypt($request->password);
            $user->save();

            return response()->json([
                'error' => false,
                'user' => $user,
                'message' => "User password was updated successfully"
            ], 200);

        }catch(Exception $error){
            Log::info('AgencyController@updatePassword error message: ' . $error->getMessage());
            $message = "Unable to complete request.";
            return response()->json(['message' => $message], 500);
        }
    }

    /**
     * Get a validator for an incoming request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validateUserDetails(array $data)
    {
        return Validator::make($data, [
            'first_name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'role' => 'required',
            'image_file' => 'sometimes|image|mimes:jpeg,png,jpg,gif,svg',

        ]);
    }
}
