<?php
/**
 * Copy over the following configs to your config
 */

use Spryker\Shared\Oms\OmsConstants;
use Spryker\Shared\Sales\SalesConstants;
use SprykerEco\Shared\Adyen\AdyenConfig;
use SprykerEco\Shared\Adyen\AdyenConstants;
use SprykerEco\Shared\AdyenApi\AdyenApiConstants;

$config[AdyenConstants::MERCHANT_ACCOUNT] = 'PUT YOUR MERCHANT ACCOUNT HERE';
$config[AdyenConstants::SOFORT_RETURN_URL] = 'SOFORT RETURN URL';
$config[AdyenConstants::MULTIPLE_PARTIAL_CAPTURE_ENABLED] = false;
$config[AdyenConstants::SOCIAL_SECURITY_NUMBER_COUNTRIES_MANDATORY] = [
    'SE',
    'FI',
    'NO',
    'DK',
];

$config[AdyenApiConstants::API_KEY] = 'PUT YOUR API KEY HERE';
$config[AdyenApiConstants::GET_PAYMENT_METHODS_ACTION_URL] = 'https://checkout-test.adyen.com/v32/paymentMethods';
$config[AdyenApiConstants::MAKE_PAYMENT_ACTION_URL] = 'https://checkout-test.adyen.com/v32/payments';
$config[AdyenApiConstants::PAYMENTS_DETAILS_ACTION_URL] = 'https://checkout-test.adyen.com/v32/payments/details';
$config[AdyenApiConstants::AUTHORIZE_ACTION_URL] = 'https://pal-test.adyen.com/pal/servlet/Payment/v30/authorise';
$config[AdyenApiConstants::AUTHORIZE_3D_ACTION_URL] = 'https://pal-test.adyen.com/pal/servlet/Payment/v30/authorise3d';
$config[AdyenApiConstants::CAPTURE_ACTION_URL] = 'https://pal-test.adyen.com/pal/servlet/Payment/v30/capture';
$config[AdyenApiConstants::CANCEL_ACTION_URL] = 'https://pal-test.adyen.com/pal/servlet/Payment/v30/cancel';
$config[AdyenApiConstants::REFUND_ACTION_URL] = 'https://pal-test.adyen.com/pal/servlet/Payment/v30/refund';
$config[AdyenApiConstants::CANCEL_OR_REFUND_ACTION_URL] = 'https://pal-test.adyen.com/pal/servlet/Payment/v30/cancelOrRefund';
$config[AdyenApiConstants::TECHNICAL_CANCEL_ACTION_URL] = 'https://pal-test.adyen.com/pal/servlet/Payment/v30/technicalCancel';
$config[AdyenApiConstants::ADJUST_AUTHORIZATION_ACTION_URL] = 'https://pal-test.adyen.com/pal/servlet/Payment/v30/adjustAuthorisation';

// ---------- State machine (OMS) Configuration
$config[OmsConstants::PROCESS_LOCATION] = [
    /* ... */
    APPLICATION_ROOT_DIR . '/vendor/spryker-eco/adyen/config/Zed/Oms',
];
$config[OmsConstants::ACTIVE_PROCESSES] = [
    /* ... */
    'AdyenCreditCard01',
    'AdyenSofort01',
    'AdyenDirectDebit01',
    'AdyenKlarnaInvoice01',
];
$config[SalesConstants::PAYMENT_METHOD_STATEMACHINE_MAPPING] = [
    /* ... */
    AdyenConfig::ADYEN_CREDIT_CARD => 'AdyenCreditCard01',
    AdyenConfig::ADYEN_SOFORT => 'AdyenSofort01',
    AdyenConfig::ADYEN_DIRECT_DEBIT => 'AdyenDirectDebit01',
    AdyenConfig::ADYEN_KLARNA_INVOICE => 'AdyenKlarnaInvoice01',
];
