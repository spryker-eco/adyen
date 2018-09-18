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
    public const MERCHANT_ACCOUNT = 'ADYEN:MERCHANT_ACCOUNT';
    public const RETURN_URL = 'ADYEN:RETURN_URL';
    public const MULTIPLE_PARTIAL_CAPTURE_ENABLED = 'ADYEN:MULTIPLE_PARTIAL_CAPTURE_ENABLED';
}
