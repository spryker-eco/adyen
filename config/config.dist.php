<?php
/**
 * Copy over the following configs to your config
 */

use SprykerEco\Shared\AdyenApi\AdyenApiConstants;

$config[AdyenApiConstants::MERCHANT_ACCOUNT] = 'PUT YOUR MERCHANT ACCOUNT HERE';
$config[AdyenApiConstants::API_KEY] = 'PUT YOUR API KEY HERE';
$config[AdyenApiConstants::GET_PAYMENT_METHODS_ACTION_URL] = 'https://checkout-test.adyen.com/v32/paymentMethods';
$config[AdyenApiConstants::MAKE_PAYMENT_ACTION_URL] = 'https://checkout-test.adyen.com/v32/payments';
$config[AdyenApiConstants::AUTHORISE_ACTION_URL] = 'https://pal-test.adyen.com/pal/servlet/Payment/v30/authorise';
$config[AdyenApiConstants::AUTHORISE_3D_ACTION_URL] = 'https://pal-test.adyen.com/pal/servlet/Payment/v30/authorise3d';
$config[AdyenApiConstants::CAPTURE_ACTION_URL] = 'https://pal-test.adyen.com/pal/servlet/Payment/v30/capture';
$config[AdyenApiConstants::CANCEL_ACTION_URL] = 'https://pal-test.adyen.com/pal/servlet/Payment/v30/cancel';
$config[AdyenApiConstants::REFUND_ACTION_URL] = 'https://pal-test.adyen.com/pal/servlet/Payment/v30/refund';
$config[AdyenApiConstants::CANCEL_OR_REFUND_ACTION_URL] = 'https://pal-test.adyen.com/pal/servlet/Payment/v30/cancelOrRefund';
$config[AdyenApiConstants::TECHNICAL_CANCEL_ACTION_URL] = 'https://pal-test.adyen.com/pal/servlet/Payment/v30/technicalCancel';
$config[AdyenApiConstants::ADJUST_AUTHORISATION_ACTION_URL] = 'https://pal-test.adyen.com/pal/servlet/Payment/v30/adjustAuthorisation';
