<?php
namespace App\Helpers;

class PaymentConfig
{
    const PAYPAL_GATEWAY = 'paypal';
    const PAYSTACK_GATEWAY = 'paystack';
    const JVZ_GATEWAY = 'jvz';

	const STATUS_PROCESSING = 'processing';
    const STATUS_COMPLETED = 'completed';
	const STATUS_CANCELLED = 'cancelled';
    const STATUS_FAILED = 'failed';
	const STATUS_REFUND = 'refund';

    const TRANSACTION_TYPE_RFND = 'RFND';
    const TRANSACTION_TYPE_SALE = 'SALE';

	const CURRENCY_USD = 'USD';
	const CURRENCY_NGN = 'NGN';
	const CURRENCY_GBP = 'GBP';
	const CURRENCY_EUR = 'EUR';

	const BASIC = 'basic';
	const WHITELABEL = 'whitelabel';

	const MONTHLY = 'monthly';
    const LIFETIME = 'lifetime';
    const REVIEWER = 'yearly';

    const FRONTEND = 'front_end';
    const OTO_PLATINUM = 'platinum';
    const OTO_UNLIMITED_OR_BUSINESS = 'unlimited_or_business';
    const OTO_ENTERPRISE = 'oto_enterprise';
    const OTO_WHITELABEL_AND_RESELLER = 'oto_whitelabel_reseller';    
    const OTO_WHITELABEL_AND_RESELLER_2 = 'oto_whitelabel_reseller_2';    

    const FRONTEND_BUNDLE_1 = 'front_end_bundle_1';
    const FRONTEND_BUNDLE_2 = 'front_end_bundle_2';
}
