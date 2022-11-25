<?php
namespace App\Helpers;

use App\Helpers\PaymentConfig;
use App\Helpers\Helper;
use App\Mail\FrontendSubMail;
use App\Mail\SubAddonMail;
use App\Helpers\PaymentTransactionLogger;
use Illuminate\Support\Facades\Mail;
use Log, Exception;
use App\Models\User;
use App\Models\SubscriptionAddonModel;
use App\Models\SubscriptionModel as Subscription;

use Auth;

class SubscriptionManager {

	const TYPE_REGULAR = 'regular';
	const TYPE_PRO = 'pro';

	public static function today()
	{
		return strtotime("now");
	}

	public static function months($n)
	{
		return $n === 1 ? strtotime("+$n month") : strtotime("+$n months");
	}

	public static function oneMonth()
	{
		return strtotime("+1 month");
	}

	public static function sixMonths()
	{
		return strtotime("+6 months");
	}

	public static function twelveMonths()
	{
		return strtotime("+12 months");
	}

	public static function oneYear()
	{
		return strtotime("+1 year");
    }

    public static function hundredYears()
	{
		return strtotime("+100 years");
	}

	public static function addUser($sub_data, $type)
	{
		$user = User::firstOrNew(['email' => $sub_data['email']]);

		if ($user->id)
		{
			$user->new = false;

			return $user;
		}
		else
		{
			$plain_password = !empty($sub_data['password']) ? $sub_data['password'] : Helper::randomPassword();

            $user->name =  $sub_data['firstname']." ".$sub_data['lastname'];
            $user->email = $sub_data['email'];
            $user->password = bcrypt($plain_password);
            $user->role = 'member';
            $user->is_active = true;
            $user->added_by = $sub_data['added_by'];
            $user->uuid = (string) \Str::uuid();
            $user->admin_id = $sub_data['admin_id'];


            $user->save();

            $user->plain_password = $plain_password;
            $user->new = true;

            // self::createWorkspace($user);
            // webhookSubscription($user);
			addToList($user);
			return $user;
        }
    }

	public static function addFrontEndSubscription($sub_data, $start, $end, $type = '', $log_txn = true, $extra_subs = [])
	{
		$user = SubscriptionManager::addUser(array_merge($sub_data, ['type' => $type]), $type);

        $sub = Subscription::firstOrNew(['user_id' => $user->id]);


		if (!$sub->created_at)
		{
			$sub->start_date = $start;
            $sub->end_date = $end;
            $sub->status = true;
            $sub->name = $type;

			$sub->type = 'lifetime';

			$sub->save();

			self::sendBasicSubEmail($user);
		}
		else
		{
			$sub_array = $extra_subs;

			if ( !empty($start) && !empty($end) )
				$sub_array = array_merge([
					'start_date' => $start,
					'end_date' => $end,
                    'type' => 'lifetime',
                    'status' => true,
                    'name' => PaymentConfig::FRONTEND
				], $extra_subs);

			Subscription::where('user_id', $user->id)->update($sub_array);
        }
        updateUserSubConfig($user, $type);
        self::registerUserSubscriptions($sub);

		if ($log_txn === true)
			self::logPaymentTransaction($sub_data, $type);

		return $user;
	}

	public static function processFrontEndRefund($sub_data, $sub_type, $log_txn = true)
	{
		$user = User::where(['email' => $sub_data['email']])->first();

		if ($user)
		{
            $sub = $user->frontEnd;

			if ($sub)
			{
                $userSub = Subscription::where('user_id', $user->id)->first();
                $userSub->status = false;
                $userSub->save();

				self::cancelMainSubscription($user);
			}
            resetUserSubConfig($user, $sub_type);
		}

		if ($log_txn === true)
			self::logPaymentTransaction($sub_data, $sub_type);
	}

	public static function cancelMainSubscription($user)
	{
        $user->is_active = false;
        $user->save();
	}

    public static function addUnlimitedSubscription($sub_data, $start, $end, $type = '', $log_txn = true, $extra_subs = [])
    {
        $user = SubscriptionManager::addUser(array_merge($sub_data, ['type' => $type]), $type);

        $sub = Subscription::firstOrNew(['user_id' => $user->id]);


		if (!$sub->created_at)
		{
			$sub->start_date = $start;
            $sub->end_date = $end;
            $sub->status = true;
            $sub->name = PaymentConfig::OTO_UNLIMITED_OR_BUSINESS;

			$sub->type = 'lifetime';

			$sub->save();

			self::sendBasicSubEmail($user);
		}
		else
		{
			$sub_array = $extra_subs;

			if ( !empty($start) && !empty($end) )
				$sub_array = array_merge([
					'start_date' => $start,
					'end_date' => $end,
                    'type' => 'lifetime',
                    'status' => true,
                    'name' => PaymentConfig::OTO_UNLIMITED_OR_BUSINESS
				], $extra_subs);

			Subscription::where('user_id', $user->id)->update($sub_array);
        }
        updateUserSubConfig($user, $type);
        self::registerUserSubscriptions($sub);

		if ($log_txn === true)
			self::logPaymentTransaction($sub_data, $type);

		return $user;
    }

    public static function processUnlimitedRefund($sub_data, $sub_type, $log_txn = true)
	{
		$user = User::where(['email' => $sub_data['email']])->first();

		if ($user)
		{
            $sub = $user->frontEnd;

			if ($sub)
			{
                $userSub = Subscription::where('user_id', $user->id)->first();
                $userSub->status = false;
                $userSub->save();

				self::cancelMainSubscription($user);
			}
            resetUserSubConfig($user, $sub_type);
		}

		if ($log_txn === true)
			self::logPaymentTransaction($sub_data, $sub_type);
    }

    public static function addOTOSubscription($sub_data, $start, $end, $sub_type, $log_txn = true)
	{
        $user = User::where(['email' => $sub_data['email']])->first();
		$sub = null;

           if ($user)
           {
                $sub = $user->frontEnd;

                if ($sub){
                    $oto = SubscriptionAddonModel::where('subscription_id', $sub->id)
                        ->where('name', $sub_type)->first();
                    if($oto){
                        $oto->status = true;
                        $oto->start_date = $start;
                        $oto->end_date = $end;
                        $oto->save();
                    }

                    Mail::to($user)->send(new SubAddonMail($user));
                }
                updateUserSubConfig($user, $sub_type);
           }

		if ($log_txn === true)
		    self::logPaymentTransaction($sub_data, $sub_type);
        return true;
    }

    public static function processOTORefund($sub_data, $sub_type, $log_txn = true)
	{
        $user = User::where(['email' => $sub_data['email']])->first();

		if ($user)
		{
			$sub = $user->frontEnd;

            if ($sub){
                $oto = SubscriptionAddonModel::where('subscription_id', $sub->id)
                    ->where('name', $sub_type)->first();
                if($oto){
                    $oto->status = false;
                    $oto->save();
                }

            }
            resetUserSubConfig($user, $sub_type);
		}

		if ($log_txn === true)
		    self::logPaymentTransaction($sub_data, $sub_type);
        return true;
    }

	public static function addFullBundleSubscription($sub_data, $start, $end, $type = '', $log_txn = true, $extra_subs = [])
    {
        $user = SubscriptionManager::addUser(array_merge($sub_data, ['type' => $type]), PaymentConfig::FRONTEND);

        $sub = Subscription::firstOrNew(['user_id' => $user->id]);


		if (!$sub->created_at)
		{
			$sub->start_date = $start;
            $sub->end_date = $end;
            $sub->status = true;
            $sub->name = PaymentConfig::FRONTEND;

			$sub->type = 'lifetime';

			$sub->save();

			self::sendBasicSubEmail($user);
		}
		else
		{
			$sub_array = $extra_subs;

			if ( !empty($start) && !empty($end) )
				$sub_array = array_merge([
					'start_date' => $start,
					'end_date' => $end,
                    'type' => 'lifetime',
                    'status' => true,
                    'name' => PaymentConfig::FRONTEND
				], $extra_subs);

			Subscription::where('user_id', $user->id)->update($sub_array);
        }
        updateUserSubConfig($user, PaymentConfig::FRONTEND);
        self::registerUserSubscriptions($sub);
		
		self::activateAddonSub($sub, PaymentConfig::OTO_UNLIMITED_OR_BUSINESS);
		updateUserSubConfig($user, PaymentConfig::OTO_UNLIMITED_OR_BUSINESS);

		self::activateAddonSub($sub, PaymentConfig::OTO_PLATINUM);
		updateUserSubConfig($user, PaymentConfig::OTO_PLATINUM);

		self::activateAddonSub($sub, PaymentConfig::OTO_ENTERPRISE);
		updateUserSubConfig($user, PaymentConfig::OTO_ENTERPRISE);
		self::activateAddonSub($sub, PaymentConfig::OTO_WHITELABEL_AND_RESELLER_2);
		updateUserSubConfig($user, PaymentConfig::OTO_WHITELABEL_AND_RESELLER_2);

		if ($log_txn === true)
			self::logPaymentTransaction($sub_data, $type);

		return $user;
    }

	public static function processFullBundleRefund($sub_data, $sub_type, $log_txn = true)
	{
		$user = User::where(['email' => $sub_data['email']])->first();

		if ($user)
		{
            $sub = $user->frontEnd;

			if ($sub)
			{
                $userSub = Subscription::where('user_id', $user->id)->first();
                $userSub->status = false;
                $userSub->save();

				self::cancelMainSubscription($user);
			}
			resetUserSubConfig($user, PaymentConfig::OTO_UNLIMITED_OR_BUSINESS);
			resetUserSubConfig($user, PaymentConfig::OTO_PLATINUM);
			resetUserSubConfig($user, PaymentConfig::OTO_ENTERPRISE);
            resetUserSubConfig($user, PaymentConfig::OTO_WHITELABEL_AND_RESELLER_2);
		}

		if ($log_txn === true)
			self::logPaymentTransaction($sub_data, $sub_type);
    }

	public static function addPassBundleSubscription($sub_data, $start, $end, $type = '', $log_txn = true, $extra_subs = [])
    {
        $user = SubscriptionManager::addUser(array_merge($sub_data, ['type' => $type]), PaymentConfig::FRONTEND);

        $sub = Subscription::firstOrNew(['user_id' => $user->id]);


		if (!$sub->created_at)
		{
			$sub->start_date = $start;
            $sub->end_date = $end;
            $sub->status = true;
            $sub->name = PaymentConfig::FRONTEND;

			$sub->type = 'lifetime';

			$sub->save();

			self::sendBasicSubEmail($user);
		}
		else
		{
			$sub_array = $extra_subs;

			if ( !empty($start) && !empty($end) )
				$sub_array = array_merge([
					'start_date' => $start,
					'end_date' => $end,
                    'type' => 'lifetime',
                    'status' => true,
                    'name' => PaymentConfig::FRONTEND
				], $extra_subs);

			Subscription::where('user_id', $user->id)->update($sub_array);
        }
        updateUserSubConfig($user, PaymentConfig::FRONTEND);
        self::registerUserSubscriptions($sub);
		
		self::activateAddonSub($sub, PaymentConfig::OTO_UNLIMITED_OR_BUSINESS);
		updateUserSubConfig($user, PaymentConfig::OTO_UNLIMITED_OR_BUSINESS);

		self::activateAddonSub($sub, PaymentConfig::OTO_PLATINUM);
		updateUserSubConfig($user, PaymentConfig::OTO_PLATINUM);

		self::activateAddonSub($sub, PaymentConfig::OTO_ENTERPRISE);
		updateUserSubConfig($user, PaymentConfig::OTO_ENTERPRISE);
		self::activateAddonSub($sub, PaymentConfig::OTO_WHITELABEL_AND_RESELLER);
		updateUserSubConfig($user, PaymentConfig::OTO_WHITELABEL_AND_RESELLER);

		if ($log_txn === true)
			self::logPaymentTransaction($sub_data, $type);

		return $user;
    }

	public static function processPassBundleRefund($sub_data, $sub_type, $log_txn = true)
	{
		$user = User::where(['email' => $sub_data['email']])->first();

		if ($user)
		{
            $sub = $user->frontEnd;

			if ($sub)
			{
                $userSub = Subscription::where('user_id', $user->id)->first();
                $userSub->status = false;
                $userSub->save();

				self::cancelMainSubscription($user);
			}
			resetUserSubConfig($user, PaymentConfig::OTO_UNLIMITED_OR_BUSINESS);
			resetUserSubConfig($user, PaymentConfig::OTO_PLATINUM);
			resetUserSubConfig($user, PaymentConfig::OTO_ENTERPRISE);
            resetUserSubConfig($user, PaymentConfig::OTO_WHITELABEL_AND_RESELLER);
		}

		if ($log_txn === true)
			self::logPaymentTransaction($sub_data, $sub_type);
    }

    

   	public static function logPaymentTransaction($sub_data, $sub_type)
   	{
   		PaymentTransactionLogger::log(
   			$sub_data['fullname'],
   			$sub_data['email'],
   			$sub_data['payment_gateway'],
   			$sub_data['amount'],
   			$sub_data['payment_status'],
   			$sub_data['txn_id'],
   			$sub_type,
   			$sub_data['order_id']
   		);
   	}

   	public static function sendBasicSubEmail($user)
   	{
        try{
            Mail::to($user->email)->send(new FrontendSubMail($user));
        }catch(Exception $error){
            Log::info($error->getMessage());
        }
    }

    private  static function registerUserSubscriptions($sub){

        self::addSubscriptionAddon($sub, PaymentConfig::OTO_PLATINUM);
        self::addSubscriptionAddon($sub, PaymentConfig::OTO_UNLIMITED_OR_BUSINESS);
        self::addSubscriptionAddon($sub, PaymentConfig::OTO_ENTERPRISE);
        self::addSubscriptionAddon($sub, PaymentConfig::OTO_WHITELABEL_AND_RESELLER);
		self::addSubscriptionAddon($sub, PaymentConfig::OTO_WHITELABEL_AND_RESELLER_2);




    }

    private static function addSubscriptionAddon($sub, $name){
        $addon = new SubscriptionAddonModel();
        $addon->subscription_id = $sub->id;
        $addon->name = $name;
        $addon->status = false;
        if($name == 'reseller' || $name == 'whitelabel'){
            $addon->limit = 0;

        }
        $addon->type = 'lifetime';
        $addon->save();

        return $addon;
    }

	// public static function addFullBundleSubscription($sub_data, $start, $end, $type = '', $log_txn = true, $extra_subs = [])
    // {
    //     $user = SubscriptionManager::addUser(array_merge($sub_data, ['type' => $type]), PaymentConfig::FRONTEND_COMMERCIAL);

    //     $sub = Subscription::firstOrNew(['user_id' => $user->id]);


	// 	if (!$sub->created_at)
	// 	{
	// 		$sub->start_date = $start;
    //         $sub->end_date = $end;
    //         $sub->status = true;
    //         $sub->name = PaymentConfig::FRONTEND_COMMERCIAL;

	// 		$sub->type = 'lifetime';

	// 		$sub->save();

	// 		self::sendBasicSubEmail($user);
	// 	}
	// 	else
	// 	{
	// 		$sub_array = $extra_subs;

	// 		if ( !empty($start) && !empty($end) )
	// 			$sub_array = array_merge([
	// 				'start_date' => $start,
	// 				'end_date' => $end,
    //                 'type' => 'lifetime',
    //                 'status' => true,
    //                 'name' => PaymentConfig::FRONTEND_COMMERCIAL
	// 			], $extra_subs);

	// 		Subscription::where('user_id', $user->id)->update($sub_array);
    //     }
    //     updateUserSubConfig($user, PaymentConfig::FRONTEND_COMMERCIAL);
    //     self::registerUserSubscriptions($sub);
		
	// 	self::activateAddonSub($sub, PaymentConfig::OTO_PROFESSIONAL);
	// 	updateUserSubConfig($user, PaymentConfig::OTO_PROFESSIONAL);

	// 	self::activateAddonSub($sub, PaymentConfig::OTO_AGENCY_AND_CONSULTANCY);
	// 	updateUserSubConfig($user, PaymentConfig::OTO_AGENCY_AND_CONSULTANCY);

	// 	self::activateAddonSub($sub, PaymentConfig::OTO_WHITELABEL_PRO);
	// 	updateUserSubConfig($user, PaymentConfig::OTO_WHITELABEL_PRO);

	// 	if ($log_txn === true)
	// 		self::logPaymentTransaction($sub_data, $type);

	// 	return $user;
    // }

	// public static function processFullBundleRefund($sub_data, $sub_type, $log_txn = true)
	// {
	// 	$user = User::where(['email' => $sub_data['email']])->first();

	// 	if ($user)
	// 	{
    //         $sub = $user->frontEnd;

	// 		if ($sub)
	// 		{
    //             $userSub = Subscription::where('user_id', $user->id)->first();
    //             $userSub->status = false;
    //             $userSub->save();

	// 			self::cancelMainSubscription($user);
	// 		}
	// 		resetUserSubConfig($user, PaymentConfig::OTO_PROFESSIONAL);
	// 		resetUserSubConfig($user, PaymentConfig::OTO_AGENCY_AND_CONSULTANCY);
	// 		resetUserSubConfig($user, PaymentConfig::OTO_WHITELABEL_PRO);
    //         resetUserSubConfig($user, PaymentConfig::FRONTEND_COMMERCIAL);
	// 	}

	// 	if ($log_txn === true)
	// 		self::logPaymentTransaction($sub_data, $sub_type);
    // }

	public static function activateAddonSub($sub, $sub_type){
		$oto = SubscriptionAddonModel::where('subscription_id', $sub->id)
                        ->where('name', $sub_type)->first();
		if($oto){
			$oto->status = true;
			$oto->start_date = time();
			$oto->end_date = time();
			$oto->save();
		}
	}

}
