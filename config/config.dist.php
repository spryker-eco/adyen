<?php
/**
 * Copy over the following configs to your config
 */

use Spryker\Shared\Kernel\KernelConstants;
use Spryker\Shared\Oms\OmsConstants;
use Spryker\Shared\Sales\SalesConstants;
use SprykerEco\Shared\Adyen\AdyenConfig;
use SprykerEco\Shared\Adyen\AdyenConstants;
use SprykerEco\Shared\AdyenApi\AdyenApiConstants;

$config[AdyenConstants::MERCHANT_ACCOUNT] = 'PUT YOUR MERCHANT ACCOUNT HERE';
$config[AdyenConstants::REQUEST_CHANNEL] = 'Web'; //Has to be "Web"
$config[AdyenConstants::SDK_CHECKOUT_SECURED_FIELDS_URL] = 'JS_SDK_URL';
$config[AdyenConstants::SDK_CHECKOUT_SHOPPER_JS_URL] = 'SHOPPER_JS_SDK_URL';
$config[AdyenConstants::SDK_CHECKOUT_SHOPPER_CSS_URL] = 'SHOPPER_CSS_SDK_URL';
$config[AdyenConstants::SDK_CHECKOUT_SHOPPER_JS_INTEGRITY_HASH] = 'JS_INTEGRITY_HASH';
$config[AdyenConstants::SDK_CHECKOUT_SHOPPER_CSS_INTEGRITY_HASH] = 'CSS_INTEGRITY_HASH';
$config[AdyenConstants::SDK_ENVIRONMENT] = 'SDK_ENVIRONMENT_NAME';
$config[AdyenConstants::SDK_CHECKOUT_ORIGIN_KEY] = 'ORIGIN_KEY';
$config[AdyenConstants::SOFORT_RETURN_URL] = 'SOFORT_RETURN_URL';
$config[AdyenConstants::CREDIT_CARD_3D_RETURN_URL] = 'CREDIT_CARD_3D_RETURN_URL';
$config[AdyenConstants::IDEAL_RETURN_URL] = 'IDEAL_RETURN_URL';
$config[AdyenConstants::PAY_PAL_RETURN_URL] = 'PAY_PAL_RETURN_URL';
$config[AdyenConstants::ALI_PAY_RETURN_URL] = 'ALI_PAY_RETURN_URL';
$config[AdyenConstants::WE_CHAT_PAY_RETURN_URL] = 'WE_CHAT_PAY_RETURN_URL';
$config[AdyenConstants::KLARNA_RETURN_URL] = 'KLARNA_RETURN_URL';
$config[AdyenConstants::CREDIT_CARD_3D_SECURE_ENABLED] = true;
$config[AdyenConstants::MULTIPLE_PARTIAL_CAPTURE_ENABLED] = false;
$config[AdyenConstants::SOCIAL_SECURITY_NUMBER_COUNTRIES_MANDATORY] = [
    'SE',
    'FI',
    'NO',
    'DK',
];
$config[AdyenConstants::IDEAL_ISSUERS_LIST] = [
    '1121' => 'Test Issuer',
    '1151' => 'Test Issuer 2',
    '1152' => 'Test Issuer 3',
    '1153' => 'Test Issuer 4',
    '1154' => 'Test Issuer 5',
    '1155' => 'Test Issuer 6',
    '1156' => 'Test Issuer 7',
    '1157' => 'Test Issuer 8',
    '1158' => 'Test Issuer 9',
    '1159' => 'Test Issuer 10',
    '1160' => 'Test Issuer Refused',
    '1161' => 'Test Issuer Pending',
    '1162' => 'Test Issuer Cancelled',
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
    'AdyenPrepayment01',
    'AdyenIdeal01',
    'AdyenPayPal01',
    'AdyenAliPay01',
    'AdyenWeChatPay01',
];
$config[SalesConstants::PAYMENT_METHOD_STATEMACHINE_MAPPING] = [
    /* ... */
    AdyenConfig::ADYEN_CREDIT_CARD => 'AdyenCreditCard01',
    AdyenConfig::ADYEN_SOFORT => 'AdyenSofort01',
    AdyenConfig::ADYEN_DIRECT_DEBIT => 'AdyenDirectDebit01',
    AdyenConfig::ADYEN_KLARNA_INVOICE => 'AdyenKlarnaInvoice01',
    AdyenConfig::ADYEN_PREPAYMENT => 'AdyenPrepayment01',
    AdyenConfig::ADYEN_IDEAL => 'AdyenIdeal01',
    AdyenConfig::ADYEN_PAY_PAL => 'AdyenPayPal01',
    AdyenConfig::ADYEN_ALI_PAY => 'AdyenAliPay01',
    AdyenConfig::ADYEN_WE_CHAT_PAY => 'AdyenWeChatPay01',
];
$config[KernelConstants::DOMAIN_WHITELIST] = [
    /* ... */
    'adyen.com', // trusted Adyen domains,
    'test.adyen.com', // For test env
];
