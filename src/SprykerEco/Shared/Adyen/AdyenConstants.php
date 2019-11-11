<?php

/**
 * MIT License
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerEco\Shared\Adyen;

/**
 * Declares global environment configuration keys. Do not use it for other class constants.
 */
interface AdyenConstants
{
    /**
     * Specification:
     * - Merchant account setting.
     *
     * @api
     */
    public const MERCHANT_ACCOUNT = 'ADYEN:MERCHANT_ACCOUNT';

    /**
     * Specification:
     * - URL of Secured Fields SDK setting.
     *
     * @api
     */
    public const SDK_CHECKOUT_SECURED_FIELDS_URL = 'ADYEN:SDK_CHECKOUT_SECURED_FIELDS_URL';

    /**
     * Specification:
     * - Origin key setting for Secured Fields SDK.
     *
     * @api
     */
    public const SDK_CHECKOUT_ORIGIN_KEY = 'ADYEN:SDK_CHECKOUT_ORIGIN_KEY';

    /**
     * Specification:
     * - Uses for the callback of the Sofort payment type.
     *
     * @api
     */
    public const SOFORT_RETURN_URL = 'ADYEN:SOFORT_RETURN_URL';

    /**
     * Specification:
     * - Uses for the callback of the Credit Card 3D Secure payment type.
     *
     * @api
     */
    public const CREDIT_CARD_3D_RETURN_URL = 'ADYEN:CREDIT_CARD_3D_RETURN_URL';

    /**
     * Specification:
     * - Uses for the callback of the Ideal payment type.
     *
     * @api
     */
    public const IDEAL_RETURN_URL = 'ADYEN:IDEAL_RETURN_URL';

    /**
     * Specification:
     * - Uses for the callback of the PayPal payment type.
     *
     * @api
     */
    public const PAY_PAL_RETURN_URL = 'ADYEN:PAY_PAL_RETURN_URL';

    /**
     * Specification:
     * - Uses for the callback of the AliPay payment type.
     *
     * @api
     */
    public const ALI_PAY_RETURN_URL = 'ADYEN:ALI_PAY_RETURN_URL';

    /**
     * Specification:
     * - Uses for the callback of the WeChat Pay payment type.
     *
     * @api
     */
    public const WE_CHAT_PAY_RETURN_URL = 'ADYEN:WE_CHAT_PAY_RETURN_URL';

    /**
     * Specification:
     * - Uses for the callback of the Klarna Invoice payment type.
     *
     * @api
     */
    public const KLARNA_INVOICE_RETURN_URL = 'ADYEN:KLARNA_INVOICE_RETURN_URL';

    /**
     * Specification:
     * - Uses for the callback of the Bank Transfer payment type.
     *
     * @api
     */
    public const PREPAYMENT_RETURN_URL = 'ADYEN:PREPAIMENT_RETURN_URL';

    /**
     * Specification:
     * - Multiple partial capture setting for OMS processing.
     *
     * @api
     */
    public const MULTIPLE_PARTIAL_CAPTURE_ENABLED = 'ADYEN:MULTIPLE_PARTIAL_CAPTURE_ENABLED';

    /**
     * Specification:
     * - Uses to enable 3D Secure for the Credit Card payment type.
     *
     * @api
     */
    public const CREDIT_CARD_3D_SECURE_ENABLED = 'ADYEN:CREDIT_CARD_3D_SECURE_ENABLED';

    /**
     * Specification:
     * - List of countries where social security number is required.
     *
     * @api
     */
    public const SOCIAL_SECURITY_NUMBER_COUNTRIES_MANDATORY = 'ADYEN:SOCIAL_SECURITY_NUMBER_COUNTRIES_MANDATORY';

    /**
     * Specification:
     * - List of issuers for the Ideal payment type.
     *
     * @api
     */
    public const IDEAL_ISSUERS_LIST = 'ADYEN:IDEAL_ISSUERS_LIST';

    /**
     * Specification:
     * - Request channel setting.
     *
     * @api
     */
    public const REQUEST_CHANNEL = 'ADYEN:REQUEST_CHANNEL';
}
