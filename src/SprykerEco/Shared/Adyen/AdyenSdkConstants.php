<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Shared\Adyen;

/**
 * Declares global environment configuration keys. Do not use it for other class constants.
 */
interface AdyenSdkConstants
{
    public const REQUEST_TYPE_FIELD = 'type';
    public const ENCRYPTED_CARD_NUMBER_FIELD = 'encryptedCardNumber';
    public const ENCRYPTED_EXPIRY_MONTH_FIELD = 'encryptedExpiryMonth';
    public const ENCRYPTED_EXPIRY_YEAR_FIELD = 'encryptedExpiryYear';
    public const ENCRYPTED_SECURITY_CODE_FIELD = 'encryptedSecurityCode';
}
