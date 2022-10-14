<?php

namespace App\Models;

use App\Helpers\PaymentConfig;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasFactory;
    use Notifiable; 
    use HasRoles; 

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'job_role',
        'company',
        'website',
        'email',
        'password',
        'phone_number',
        'address',
        'city',
        'plan_id',
        'postal_code',
        'country',
        'profile_photo_path',
        'oauth_id',
        'oauth_type',
        'referral_id',
        'referred_by',
        'referral_payment_method',
        'referral_paypal',
        'referral_bank_requisites',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token'
    ];

    /**
     * The attributes that are not mass assignable.
     *
     * @var array
     */
    protected $guarded = [
        'balance',
        'available_chars',
        'group',
        'status'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    protected $appends = [
        'first_name',
        'last_name',
        'addon_subscriptions',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    public function path()
    {
        return route('admin.users.show', $this);
    }

    /**
     * User can have many support tickets
     */
    public function support()
    {
        return $this->hasMany(Support::class);
    }

    /**
     * User can have many TTS results
     */
    public function result()
    {
        return $this->hasMany(Result::class);
    }

    /**
     * User can have many payments
     */
    public function payment()
    {
        return $this->hasMany(Payment::class);
    }

    
    public function subscription()
    {
        return $this->hasOne(Subscription::class);
    }


    public function hasActiveSubscription()
    {
        return optional($this->subscription)->isActive() ?? false;
    }

    public function getFirstNameAttribute()
    {
        $names = $this->splitFullname($this->name);

        return $names['firstname'];
    }

    public function getLastNameAttribute()
    {
        $names = $this->splitFullname($this->name);

        return $names['lastname'];
    }

    public function splitFullname($fullname)
	{
		$parts = explode(' ', $fullname);
		$lastname = array_pop($parts);
		$firstname = implode(' ', $parts);

		$data['firstname'] = $firstname;
		$data['lastname']  = $lastname;

		return $data;
    }

    public function frontEnd(){
		return $this->hasOne('App\Models\SubscriptionModel', 'user_id', 'id');
    }

	public function getAddonSubscriptionsAttribute(){
        return $this->getAddonSubscriptions($this->id);
    }

	private function getAddonSubscriptions($userId){
		$subscription = SubscriptionModel::where('user_id', $userId)->first();
		$platinum = null;
		$unlimited = null;
		$enterprise = null;
		$whitelabel_1 = null;
		$whitelabel_2 = null;

		if($subscription){
            $platinum = SubscriptionAddonModel::where('subscription_id', $subscription->id)
                ->where('name',PaymentConfig::OTO_PLATINUM)->first();
            $unlimited = SubscriptionAddonModel::where('subscription_id', $subscription->id)
                ->where('name', PaymentConfig::OTO_UNLIMITED_OR_BUSINESS)->first();
            $enterprise = SubscriptionAddonModel::where('subscription_id', $subscription->id)
                ->where('name', PaymentConfig::OTO_ENTERPRISE)->first();
            $whitelabel_1 = SubscriptionAddonModel::where('subscription_id', $subscription->id)
                ->where('name', PaymentConfig::OTO_WHITELABEL_AND_RESELLER)->first();
            $whitelabel_2 = SubscriptionAddonModel::where('subscription_id', $subscription->id)
                ->where('name', PaymentConfig::OTO_WHITELABEL_AND_RESELLER_2)->first();
        }

		return [
            'platinum'  => [
                'id' => ($platinum)? $platinum->id : '',
                'status' => ($platinum)? $platinum->status : false,
                'limit' => ($platinum)? $platinum->limit : 0,
                'start_date' => ($platinum)? $platinum->start_date : '',
                'end_date' => ($platinum)? $platinum->end_date : '',
                'type' => ($platinum)? $platinum->type : '',
                'name' => 'Platinum'
            ],
            'unlimited' => [
                'id' => ($unlimited)? $unlimited->id : '',
                'status' => ($unlimited)? $unlimited->status : false,
                'limit' => ($unlimited)? $unlimited->limit : 0,

                'start_date' => ($unlimited)? $unlimited->start_date : '',
                'end_date' => ($unlimited)? $unlimited->end_date : '',
                'type' => ($unlimited)? $unlimited->type: '',
                'name' => 'Unlimited or Business'
            ],
            'enterprise' => [
                'id' => ($enterprise)? $enterprise->id : '',
                'status' => ($enterprise)? $enterprise->status : false,
                'limit' => ($enterprise)? $enterprise->limit : 0,

                'start_date' => ($enterprise)? $enterprise->start_date : '',
                'end_date' => ($enterprise)? $enterprise->end_date : '',
                'type' => ($enterprise)? $enterprise->type: '',
                'name' => 'Enterprise'
            ],
            'whitelabel_1'  => [
                'id' => ($whitelabel_1)? $whitelabel_1->id : '',
                'status' => ($whitelabel_1)? $whitelabel_1->status : false,
                'limit' => ($whitelabel_1)? $whitelabel_1->limit : 0,

                'start_date' => ($whitelabel_1)? $whitelabel_1->start_date : '',
                'end_date' => ($whitelabel_1)? $whitelabel_1->end_date : '',
                'type' => ($whitelabel_1)? $whitelabel_1->type :'',
                'name' => 'Whitelabel + Reseller 50 Accounts'
            ],
            'whitelabel_2'  => [
                'id' => ($whitelabel_2)? $whitelabel_2->id : '',
                'status' => ($whitelabel_2)? $whitelabel_2->status : false,
                'limit' => ($whitelabel_2)? $whitelabel_2->limit : 0,
                'start_date' => ($whitelabel_2)? $whitelabel_2->start_date: '',
                'end_date' => ($whitelabel_2)? $whitelabel_2->end_date: '',
                'type' => ($whitelabel_2)? $whitelabel_2->type :'',
                'name' => 'Whitelabel + Reseller 150 Accounts'
            ],

            
        ];
	}

}
