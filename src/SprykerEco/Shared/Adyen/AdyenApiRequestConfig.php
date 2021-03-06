<?php

/**
 * MIT License
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerEco\Shared\Adyen;

/**
 * Declares global environment configuration keys. Do not use it for other class constants.
 */
interface AdyenApiRequestConfig
{
    public const REQUEST_TYPE_FIELD = 'type';
    public const ENCRYPTED_CARD_NUMBER_FIELD = 'encryptedCardNumber';
    public const ENCRYPTED_EXPIRY_MONTH_FIELD = 'encryptedExpiryMonth';
    public const ENCRYPTED_EXPIRY_YEAR_FIELD = 'encryptedExpiryYear';
    public const ENCRYPTED_SECURITY_CODE_FIELD = 'encryptedSecurityCode';
    public const PAYLOAD_FIELD = 'payload';
    public const MD_FIELD = 'MD';
    public const PA_RES_FIELD = 'PaRes';
    public const SEPA_OWNER_NAME_FIELD = 'sepa.ownerName';
    public const SEPA_IBAN_NUMBER_FIELD = 'sepa.ibanNumber';
    public const BILLING_ADDRESS_FIELD = 'billingAddress';
    public const DELIVERY_ADDRESS_FIELD = 'deliveryAddress';
    public const PERSONAL_DETAILS_FIELD = 'personalDetails';
    public const IDEAL_ISSUER_FIELD = 'idealIssuer';
    public const REDIRECT_RESULT_FIELD = 'redirectResult';
}
