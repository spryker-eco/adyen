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
     * @var string
     */
    public const MERCHANT_ACCOUNT = 'ADYEN:MERCHANT_ACCOUNT';

    /**
     * @deprecated Will be removed without replacement. BC-reason only.
     *
     * Specification:
     * - URL to Adyen Checkout security fields SDK JS file.
     *
     * @api
     * @var string
     */
    public const SDK_CHECKOUT_SECURED_FIELDS_URL = 'ADYEN:SDK_CHECKOUT_SECURED_FIELDS_URL';

    /**
     * @var string
     */
    public const SDK_CHECKOUT_ORIGIN_KEY = 'ADYEN:SDK_CHECKOUT_ORIGIN_KEY';

    /**
     * @var string
     */
    public const SOFORT_RETURN_URL = 'ADYEN:SOFORT_RETURN_URL';

    /**
     * @var string
     */
    public const CREDIT_CARD_3D_RETURN_URL = 'ADYEN:CREDIT_CARD_3D_RETURN_URL';

    /**
     * @var string
     */
    public const IDEAL_RETURN_URL = 'ADYEN:IDEAL_RETURN_URL';

    /**
     * @var string
     */
    public const PAY_PAL_RETURN_URL = 'ADYEN:PAY_PAL_RETURN_URL';

    /**
     * @var string
     */
    public const ALI_PAY_RETURN_URL = 'ADYEN:ALI_PAY_RETURN_URL';

    /**
     * @var string
     */
    public const WE_CHAT_PAY_RETURN_URL = 'ADYEN:WE_CHAT_PAY_RETURN_URL';

    /**
     * @var string
     */
    public const MULTIPLE_PARTIAL_CAPTURE_ENABLED = 'ADYEN:MULTIPLE_PARTIAL_CAPTURE_ENABLED';

    /**
     * @var string
     */
    public const CREDIT_CARD_3D_SECURE_ENABLED = 'ADYEN:CREDIT_CARD_3D_SECURE_ENABLED';

    /**
     * @var string
     */
    public const SOCIAL_SECURITY_NUMBER_COUNTRIES_MANDATORY = 'ADYEN:SOCIAL_SECURITY_NUMBER_COUNTRIES_MANDATORY';

    /**
     * @var string
     */
    public const IDEAL_ISSUERS_LIST = 'ADYEN:IDEAL_ISSUERS_LIST';

    /**
     * @var string
     */
    public const REQUEST_CHANNEL = 'ADYEN:REQUEST_CHANNEL';

    /**
     * Specification:
     * - Return URL for Klarna payment method.
     *
     * @api
     * @var string
     */
    public const KLARNA_RETURN_URL = 'ADYEN:KLARNA_RETURN_URL';

    /**
     * Specification:
     * - URL to Adyen Checkout shopper SDK JS file.
     *
     * @api
     * @var string
     */
    public const SDK_CHECKOUT_SHOPPER_JS_URL = 'ADYEN:SDK_CHECKOUT_SHOPPER_JS_URL';

    /**
     * Specification:
     * - URL to Adyen Checkout shopper SDK CSS file.
     *
     * @api
     * @var string
     */
    public const SDK_CHECKOUT_SHOPPER_CSS_URL = 'ADYEN:SDK_CHECKOUT_SHOPPER_CSS_URL';

    /**
     * Specification:
     * - Subresource Integrity (SRI) hash for Checkout shopper SDK JS file.
     *
     * @api
     * @var string
     */
    public const SDK_CHECKOUT_SHOPPER_JS_INTEGRITY_HASH = 'ADYEN:SDK_CHECKOUT_SHOPPER_JS_INTEGRITY_HASH';

    /**
     * Specification:
     * - Subresource Integrity (SRI) hash for Checkout shopper SDK CSS file.
     *
     * @api
     * @var string
     */
    public const SDK_CHECKOUT_SHOPPER_CSS_INTEGRITY_HASH = 'ADYEN:SDK_CHECKOUT_SHOPPER_CSS_INTEGRITY_HASH';

    /**
     * Specification:
     * - Adyen Environment name for SDK.
     *
     * @api
     * @var string
     */
    public const SDK_ENVIRONMENT = 'ADYEN:SDK_ENVIRONMENT';
}
