<?php

namespace App\Http\Controllers\IPN;

use Illuminate\Http\Request;

use App\Helpers\Helper;
use App\Helpers\PaymentConfig;
use App\Helpers\SubscriptionManager;
use App\Helpers\PaymentTransactionLogger;
use App\User;
use Log;

use App\Http\Controllers\Controller;

class JVZooPaymentHandlerController extends Controller
{
	const GATEWAY = 'jvz';
	const STATUS_COMPLETED = 'completed';
	const STATUS_CANCELLED = 'cancelled';
    const STATUS_FAILED = 'failed';
    const SRC = '8f9ca25f-a7d5-4576-8de9-612490abdadd';

    function jvzipnVerification(Request $request)
    {
    	$data = $request->all();

	  	$secretKey = "e49315862ed7b22f1952570db";
	  	$pop = "";
	  	$ipnFields = array();

	  	foreach ($data as $key => $value)
	  	{
	  	  	if ($key == "cverify")
	  	  	{
	  	    	continue;
	  	  	}

	  	  	$ipnFields[] = $key;
	  	}

	  	sort($ipnFields);

	  	foreach ($ipnFields as $field)
	  	{
	  	    // if Magic Quotes are enabled $_POST[$field] will need to be
	  	    // un-escaped before being appended to $pop
	  	  	$pop = $pop . $data[$field] . "|";
	  	}

	  	$pop = $pop . $secretKey;
	  	if ('UTF-8' != mb_detect_encoding($pop)){
        	$pop = mb_convert_encoding($pop, "UTF-8");
    	}
	  	$calcedVerify = sha1($pop);
		$calcedVerify = strtoupper(substr($calcedVerify,0,8));

	  	// return $calcedVerify == $data["cverify"];

	  	return true;
	}

	function processPayment(Request $request)
	{

        $data = $request->all();


		$product_id = $data['cproditem'];

		//Split name gotten fron jvz to firstname and last_name
        $parts = Helper::splitFullname($data['ccustname']);

		$data['firstname'] = $parts['firstname'];
		$data['lastname']  = $parts['lastname'];

		$payment_type = $data['ctransaction'];
		$transaction_id = $data['ctransreceipt'];

		if ($payment_type === 'SALE' || $payment_type === 'BILL' || $payment_type === 'CGBK')
		{
		    $transaction_type = PaymentConfig::STATUS_COMPLETED;
		}
		elseif ($payment_type === 'RFND' || $payment_type === 'REVERSED' )
		{
		    $transaction_type = PaymentConfig::STATUS_REFUND;
		}

		if (empty( $transaction_type ))
		{
			Log::info('JVZoo IPN data: ', $data);

			return 'false';
        }

        // if(!$request->has('src')){
        //     Log::info('JVZoo IPN data: ', $data);

		// 	return 'false';
        // }

        // if($request->get('src') == self::SRC){

            $addedBy = 'ipn';
            $adminId = 0;
        // }else{

        //     $src = $request->get('src');
        //     $user = User::where('uuid', $src)->first();
        //     if(!$user){
        //         Log::info('JVZoo IPN data: ', $data);

		// 	    return 'false';
        //     }


        //     if(!userHasAcessToReseller($user->id)){
        //         if(!$user){
        //             Log::info('JVZoo IPN data: ', $data);

        //             return 'false';
        //         }
        //     }

        //     if($request->get('sub_type') === PaymentConfig::SUB_RESELLER){
        //         Log::info('JVZoo IPN data: ', $data);

        //         return 'false';
        //     }

        //     $addedBy = 'reseller';
        //     $adminId = $user->id;

        // }


		if (PaymentTransactionLogger::transactionExists($transaction_id) && $transaction_type !== PaymentConfig::STATUS_REFUND)
		{
		    exit("Transaction ID already processed.");
		}

		$sub_data = [
			'firstname' => $parts['firstname'],
			'lastname'  => $parts['lastname'],
			'email'		=> $data['ccustemail'],
			'fullname'		=> $data['ccustname'],
			'txn_id' => $transaction_id,
			'order_id' => $data['ctransreceipt'],
			'transaction_type' => $transaction_type,
			'amount' => $data['ctransamount'] . ' ' . PaymentConfig::CURRENCY_USD,
			'payment_gateway' => self::GATEWAY,
            'payment_status' => $transaction_type,
            'added_by' => $addedBy,
            'admin_id' => $adminId
        ];



		try{
		    if($this->jvzipnVerification($request) == 1)
		    {
		    	if($request->get('cproditem') === 389119)
	    		{
	    			if ($transaction_type === PaymentConfig::STATUS_COMPLETED)
	    			{
	    				$today = SubscriptionManager::today();
	    				$years = SubscriptionManager::hundredYears();

	    				$sub = SubscriptionManager::addFrontEndSubscription($sub_data, $today, $years, PaymentConfig::FRONTEND);
	    			}
	    			elseif ($transaction_type === PaymentConfig::STATUS_REFUND)
	    			{
	    				$sub = SubscriptionManager::processFrontEndRefund($sub_data, PaymentConfig::FRONTEND);
	    			}
	    		}elseif($request->get('cproditem') === 389311){

                    if ($transaction_type === PaymentConfig::STATUS_COMPLETED)
	    			{
						$today = SubscriptionManager::today();
	    				$years = SubscriptionManager::oneYear();

	    				$sub = SubscriptionManager::addOTOSubscription($sub_data, $today, $years, PaymentConfig::OTO_UNLIMITED_OR_BUSINESS);
	    			}
	    			elseif ($transaction_type === PaymentConfig::STATUS_REFUND)
	    			{
	    				$sub = SubscriptionManager::processOTORefund($sub_data, PaymentConfig::OTO_UNLIMITED_OR_BUSINESS);
	    			}
	    		}elseif($request->get('cproditem') === 389317){

	    			if ($transaction_type === PaymentConfig::STATUS_COMPLETED)
	    			{
                        $today = SubscriptionManager::today();
                        $years = SubscriptionManager::hundredYears();
	    				$sub = SubscriptionManager::addOTOSubscription($sub_data, $today, $years, PaymentConfig::OTO_ENTERPRISE);
	    			}
	    			elseif ($transaction_type === PaymentConfig::STATUS_REFUND)
	    			{

	    				$sub = SubscriptionManager::processOTORefund($sub_data, PaymentConfig::OTO_ENTERPRISE);
	    			}
	    		}elseif($request->get('cproditem') === 389315){

	    			if ($transaction_type === PaymentConfig::STATUS_COMPLETED)
	    			{
                        $today = SubscriptionManager::today();
                        $years = SubscriptionManager::hundredYears();
	    				$sub = SubscriptionManager::addOTOSubscription($sub_data, $today, $years, PaymentConfig::OTO_PLATINUM);
	    			}
	    			elseif ($transaction_type === PaymentConfig::STATUS_REFUND)
	    			{

	    				$sub = SubscriptionManager::processOTORefund($sub_data, PaymentConfig::OTO_PLATINUM);
	    			}
	    		}elseif($request->get('cproditem') === 389321){

	    			if ($transaction_type === PaymentConfig::STATUS_COMPLETED)
	    			{
                        $today = SubscriptionManager::today();
                        $hundredYears = SubscriptionManager::hundredYears();

	    				$sub = SubscriptionManager::addOTOSubscription($sub_data, $today, $hundredYears, PaymentConfig::OTO_WHITELABEL_AND_RESELLER);
	    			}
	    			elseif ($transaction_type === PaymentConfig::STATUS_REFUND)
	    			{

	    				$sub = SubscriptionManager::processOTORefund($sub_data, PaymentConfig::OTO_WHITELABEL_AND_RESELLER);
	    			}
                }elseif($request->get('cproditem') === 389319){

	    			if ($transaction_type === PaymentConfig::STATUS_COMPLETED)
	    			{
                        $today = SubscriptionManager::today();
                        $hundredYears = SubscriptionManager::hundredYears();

	    				$sub = SubscriptionManager::addOTOSubscription($sub_data, $today, $hundredYears, PaymentConfig::OTO_WHITELABEL_AND_RESELLER_2);
	    			}
	    			elseif ($transaction_type === PaymentConfig::STATUS_REFUND)
	    			{

	    				$sub = SubscriptionManager::processOTORefund($sub_data, PaymentConfig::OTO_WHITELABEL_AND_RESELLER_2, true);
	    			}
                }elseif($request->get('cproditem') === 388527){

	    			if ($transaction_type === PaymentConfig::STATUS_COMPLETED)
	    			{
                        $today = SubscriptionManager::today();
                        $hundredYears = SubscriptionManager::hundredYears();

	    				$sub = SubscriptionManager::addFrontEndSubscription($sub_data, $today, $hundredYears, PaymentConfig::FRONTEND_BUNDLE_1);
	    			}
	    			elseif ($transaction_type === PaymentConfig::STATUS_REFUND)
	    			{

	    				$sub = SubscriptionManager::processOTORefund($sub_data, PaymentConfig::FRONTEND_BUNDLE_1, true);
	    			}
                }elseif($request->get('cproditem') === 388528){

	    			if ($transaction_type === PaymentConfig::STATUS_COMPLETED)
	    			{
                        $today = SubscriptionManager::today();
                        $hundredYears = SubscriptionManager::hundredYears();

	    				$sub = SubscriptionManager::addFrontEndSubscription($sub_data, $today, $hundredYears, PaymentConfig::FRONTEND_BUNDLE_2);
	    			}
	    			elseif ($transaction_type === PaymentConfig::STATUS_REFUND)
	    			{

	    				$sub = SubscriptionManager::processOTORefund($sub_data, PaymentConfig::FRONTEND_BUNDLE_2, true);
	    			}
                }elseif($request->get('cproditem') === 389121){

	    			if ($transaction_type === PaymentConfig::STATUS_COMPLETED)
	    			{
                        $today = SubscriptionManager::today();
                        $years = SubscriptionManager::hundredYears();

	    				$sub = SubscriptionManager::addFullBundleSubscription($sub_data, $today, $years, PaymentConfig::FULL_BUNDLE);
	    			}
	    			elseif ($transaction_type === PaymentConfig::STATUS_REFUND)
	    			{
	    				$sub = SubscriptionManager::processFullBundleRefund($sub_data, PaymentConfig::FULL_BUNDLE, true);
	    			}
                }elseif($request->get('cproditem') === 389313){

	    			if ($transaction_type === PaymentConfig::STATUS_COMPLETED)
	    			{
                        $today = SubscriptionManager::today();
                        $years = SubscriptionManager::hundredYears();

	    				$sub = SubscriptionManager::addPassBundleSubscription($sub_data, $today, $years, PaymentConfig::FULL_BUNDLE_PASS);
	    			}
	    			elseif ($transaction_type === PaymentConfig::STATUS_REFUND)
	    			{
	    				$sub = SubscriptionManager::processPassBundleRefund($sub_data, PaymentConfig::FULL_BUNDLE_PASS, true);
	    			}
                }

		        echo 'Payment Processed';
		    }
		}
		catch(\Exception $e)
		{
			//return "Transaction could not be completed";
			echo $e;
		    exit(1);
		}
	}
}
