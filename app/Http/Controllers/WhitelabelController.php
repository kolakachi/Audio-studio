<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Helpers\Paths;
use Illuminate\Http\Request;
use App\Mail\ResellerWelcomeMail;
use App\Models\WhiteLabelConfigModel;
use Auth, Validator, Mail, File, Storage, Log, Session, Exception;


class WhitelabelController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(){
        $whitelabelConfig = WhiteLabelConfigModel::where('user_id', Auth::id())->first();
        $data = [
            'page' => 'whitelabel',
            'config' => $whitelabelConfig,
            'pageClass' => 'whitelabel-page'
        ];
        return view('app.whitelabel.index', $data);
    }

    public function users(){
        // if(!userHasAcessToWhitelabel(Auth::id())){
        //     $message = "Sorry, you don't have access to this feature";
        //     Session::put('errorMessage', $message);
        //     return redirect()->route('user.index');
        // }

        $users = User::where('account_type', 'whitelabel')->where('admin_id', Auth::id())->get();
        


        if(Auth::user()->role !== 'super_admin'){
            foreach ($users as $key => $user){
                if($user->role == 'super_admin' || $user->role ==  'admin'){
                        unset($users[$key]);
                }

            }
        }

        $data = [
            'page' => 'whitelabel',
            'users' => $users,
            'pageClass' => 'whitelabel-users-page'
        ];

        return view('app.whitelabel.users', $data);
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
            Log::info('WhiteLabelController@addAccount error message: ' . $error->getMessage());
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
        $user->account_type = 'whitelabel';
        $user->job_role = 'User';
        $user->admin_id = Auth::id();
        $user->added_by = Auth::id();
        $user->password = bcrypt($request->password);
        $user->save();

        return $user;
    }

    public function createWorkspace($user){
        $workspace = new WorkSpaceModel;
        $workspace->name = $user->name;
        $workspace->user_id = $user->id;
        $workspace->slug = $user->name;
        $workspace->has_request = false;
        $workspace->is_default = true;
        $workspace->email = "";
        $workspace->save();

        $userWorkspace = new UserWorkSpaceModel;
        $userWorkspace->user_id = $workspace->user_id;
        $userWorkspace->work_space_id = $workspace->id;
        $userWorkspace->role = 'super_admin';
        $userWorkspace->save();
    }

    private function setSubscription($request, $user){
        $subscriptions = (array)json_decode($request->subscriptions);
        $subId = 0;
        foreach($subscriptions as $key => $value){
            $value = (array) $value;
            if($key == 'front_end'){
                $subscription = SubscriptionModel::firstOrNew([
                    'user_id' => $user->id, 
                    'name' => $key,
                ]);

                if(!$subscription->id){
                    $subscription->status = true; 
                    $subscription->config = [
                        'ads_search' => [
                            'duration' => strtotime("+1 month"),
                            'count' => 250
                        ],
                        'normal_post' => [
                            'duration' => strtotime("+1 month"),
                            'count' => 50
                        ],
                        'cta_post' => [
                            'duration' => strtotime("+1 month"),
                            'count' => 50
                        ],
                        'slide_post' => [
                            'duration' => strtotime("+1 month"),
                            'count' => 50
                        ],
                        'rules' => [
                            'duration' => strtotime("+1 month"),
                            'count' => 50
                        ],
                        'hash_tag' => [
                            'duration' => strtotime("+1 month"),
                            'count' => 50
                        ],
                        'caption' => [
                            'duration' => strtotime("+1 month"),
                            'count' => 50
                        ],
                        'team_members' => [
                            'duration' => strtotime("+1 month"),
                            'count' => 3
                        ],
                        'workspaces' => [
                            'duration' => strtotime("+1 month"),
                            'count' => 2
                        ]
                    ];
                    $subscription->save();
                }
                
                $subId = $subscription->id; 
                
            }

            if($key == 'unlimited_pro'){
                $unlimited_pro = SubscriptionAddonModel::firstOrNew([
                    'subscription_id' => $subId,
                    'name' => $key,
                ]);
                
                $unlimited_pro->status = (isset($value['status']))? $value['status'] == 'true' : false; 
                if(!$unlimited_pro->id){
                    $unlimited_pro->config = [
                        'team_members' => [
                            'duration' => strtotime("now"),
                            'count' => 25
                        ],
                        'workspaces' => [
                            'duration' => strtotime("now"),
                            'count' => 25
                        ],
                    ];
                }
                $unlimited_pro->save(); 
                
            }

            if($key == 'dfy_audiences'){
                $dfy_audiences = SubscriptionAddonModel::firstOrNew([
                    'subscription_id' => $subId,
                    'name' => $key,
                ]);
                $dfy_audiences->status = (isset($value['status']))? $value['status'] == 'true' : false; 
                $dfy_audiences->save(); 
                
            }

            if($key == 'agency'){
                $agency = SubscriptionAddonModel::firstOrNew([
                    'subscription_id' => $subId,
                    'name' => $key,
                ]);
                $agency->status = false; 
                $agency->config = [
                    'team_members' => [
                        'duration' => strtotime("now"),
                        'count' => 0
                    ],
                    'workspaces' => [
                        'duration' => strtotime("now"),
                        'count' => 0
                    ],
                ];
                $agency->save(); 
                
            }

        }
    }

    public function deleteAccount(Request $request){
        try{
            if($request->id == ''){
                $message = "User ID is required";
                return response()->json(['message' => $message], 400);
            }
            $user = User::where('account_type', 'whitelabel')
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
            Log::info('WhiteLabelController@deleteAccount error message: ' . $error->getMessage());
            $message = "Unable to complete request.";
            return response()->json(['message' => $message], 500);
        }
    }

    public function updateAccount(Request $request){
        try{
            $user = User::where('account_type', 'whitelabel')
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
            Log::info('WhiteLabelController@updateAccount error message: ' . $error->getMessage());
            $message = "Unable to complete request.";
            return response()->json(['message' => $message], 500);
        }
    }

    public function updateSubscriptions(Request $request){
        try{
            $user = User::where('account_type', 'whitelabel')
                ->where('admin_id', Auth::id())
                ->where('id', $request->id)->first();
            // $request->subscriptions = (array)json_decode($request->subscriptions);
            if(!$user){
                return response()->json([
                    'error' => true,
                    'status_code' => 404,
                    "message" => "user not found"
                ], 404);
            }

            $this->setSubscription($request, $user);

            return response()->json([
                'error' => false,
                'user' => $user,
                'message' => "User was updated successfully"
            ], 200);

        }catch(Exception $error){
            Log::info('WhiteLabelController@updateSubscriptions error message: ' . $error->getMessage());
            $message = "Unable to complete request.";
            return response()->json(['message' => $message], 500);
        }
    }

    public function updatePassword(Request $request){
        try{
            $user = User::where('account_type', 'whitelabel')
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
            Log::info('WhiteLabelController@updatePassword error message: ' . $error->getMessage());
            $message = "Unable to complete request.";
            return response()->json(['message' => $message], 500);
        }
    }

    public function whiteLabelConfig(){
        try{
            $whitelabelConfig = WhiteLabelConfigModel::where('user_id', Auth::id())->first();
            $data = [
                'currentPage' => 'whitelabel',
                'config' => $whitelabelConfig,
            ];
    
            return view('Whitelabel.config', $data);

        }catch(Exception $error){
            Log::info('WhiteLabelController@whiteLabelConfig error message: ' . $error->getMessage());
            $message = "Unable to complete request.";
            return response()->json(['message' => $message], 500);
        }
    }

    public function updateConfigDetails(Request $request){
        try{
            $whitelabelConfig = WhiteLabelConfigModel::firstOrNew([
                'user_id' => Auth::id()
            ]);

            $whitelabelConfig->app_name = $request->app_name;
            $whitelabelConfig->domain = $request->domain;
            $whitelabelConfig->color = $request->color;
            $whitelabelConfig->secondary_color = $request->secondary_color;
            $whitelabelConfig->email = $request->email;
            $whitelabelConfig->support_url = $request->support_url;
            $whitelabelConfig->description = $request->description;
            if($request->hasFile('image_file')){
                $whitelabelConfig->logo = $this->updateLogo($request);
            }
            $whitelabelConfig->save();

            return response()->json([
                'error' => false,
                'message' => "Whitelabel Config was updated successfully"
            ], 200);

        }catch(Exception $error){
            Log::info('WhiteLabelController@updateConfigDetails error message: ' . $error->getMessage());
            $message = "Unable to complete request.";
            return response()->json(['message' => $message], 500);
        }
    }

    public function updateFacebbokAppConfigDetails(Request $request){
        try{
            $whitelabelConfig = WhiteLabelConfigModel::firstOrNew([
                'user_id' => Auth::id()
            ]);

            $whitelabelConfig->app_secret = $request->app_secret;
            $whitelabelConfig->app_id = $request->app_id;
            $whitelabelConfig->save();

            return response()->json([
                'error' => false,
                'message' => "Whitelabel Config was updated successfully"
            ], 200);
            
        }catch(Exception $error){
            Log::info('WhiteLabelController@updateConfigDetails error message: ' . $error->getMessage());
            $message = "Unable to complete request.";
            return response()->json(['message' => $message], 500);
        }
    }

    public function updateSMTPConfigDetails(Request $request){
        try{
            $whitelabelConfig = WhiteLabelConfigModel::firstOrNew([
                'user_id' => Auth::id()
            ]);

            $whitelabelConfig->mail_host = $request->mail_host;
            $whitelabelConfig->mail_port = $request->mail_port;
            $whitelabelConfig->mail_username = $request->mail_username;
            $whitelabelConfig->mail_password = $request->mail_password;
            $whitelabelConfig->mail_from_name = $request->mail_from_name;
            $whitelabelConfig->mail_from_address = $request->mail_from_address;
            $whitelabelConfig->encryption = $request->encryption;
            $whitelabelConfig->save();

            return response()->json([
                'error' => false,
                'message' => "Whitelabel Config was updated successfully"
            ], 200);
            
        }catch(Exception $error){
            Log::info('WhiteLabelController@updateConfigDetails error message: ' . $error->getMessage());
            $message = "Unable to complete request.";
            return response()->json(['message' => $message], 500);
        }
    }

    public function updateLogo($request){
        try {

            if($request->hasFile('image_file')) {

                // Upload path
                $destinationPath = storage_path('app/' .Paths::LOGO_PATH);         
                // Get file extension
                $extension = $request->file('image_file')->getClientOriginalExtension();
                // Valid extensions
                $validextensions = array("jpeg","jpg","png");
                // Check extension
                if(in_array(strtolower($extension), $validextensions)){
                  // Rename file 
                  $fileName = time() + Auth::id()."-".time().'.' . $extension;
                  // Uploading file to given path
                  $request->file('image_file')->move($destinationPath, $fileName); 

                  return $fileName;

                    // $image = WhiteLabelConfigModel::firstOrNew([
                    //     'user_id' => Auth::id(),
                    // ]);
                    // $image->logo = $fileName;
                    // $image->save();

                    // return response()->json([
                    //     'status' => 'success',
                    //     'storage' => $image
                    // ]);
                }
         
            }
          
            return '';
            // return response()->json([
            //     'status' => 'error',
            //     'message' => "unable to complete request. please upload a valid image"
            // ], 400);

        } catch (Exception $error) {

            Log::info('WhiteLabelConfigController@imageUpload error message: ' . $error->getMessage());
            $message = 'Unable to store image. Encountered an error.';
            // return response()->json([
            //     'status' => 'error',
            //     'message' => $message
            // ], 500);
            return '';
        }
    }

    public function updateWelcomeEmail(Request $request){
        try{
            $whitelabelConfig = WhiteLabelConfigModel::firstOrNew([
                'user_id' => Auth::id()
            ]);

            $whitelabelConfig->welcome_mail = $request->welcome_mail;
            $whitelabelConfig->save();

            return response()->json([
                'error' => false,
                'message' => "Whitelabel Config was updated successfully"
            ], 200);

        }catch(Exception $error){
            Log::info('WhiteLabelController@updateWelcomeEmail error message: ' . $error->getMessage());
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

    private function tokenSentToUserMail($user){
        try{
            $user = User::where('id', $user->id)->first();

            if($user){
                $user['token'] = \Str::random(50);
                $user->save();

                Mail::to($user->email)
                    ->send(new ResellerWelcomeMail($user));
            }

            return true;
        }catch(\Exception $error){
            Log::info('error message: ' . $error->getMessage());

            return false;
        }
    }
}
