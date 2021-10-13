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
    /**
     * @var string
     */
    public const REQUEST_TYPE_FIELD = 'type';

    /**
     * @var string
     */
    public const ENCRYPTED_CARD_NUMBER_FIELD = 'encryptedCardNumber';

    /**
     * @var string
     */
    public const ENCRYPTED_EXPIRY_MONTH_FIELD = 'encryptedExpiryMonth';

    /**
     * @var string
     */
    public const ENCRYPTED_EXPIRY_YEAR_FIELD = 'encryptedExpiryYear';

    /**
     * @var string
     */
    public const ENCRYPTED_SECURITY_CODE_FIELD = 'encryptedSecurityCode';

    /**
     * @var string
     */
    public const PAYLOAD_FIELD = 'payload';

    /**
     * @var string
     */
    public const MD_FIELD = 'MD';

    /**
     * @var string
     */
    public const PA_RES_FIELD = 'PaRes';

    /**
     * @var string
     */
    public const SEPA_OWNER_NAME_FIELD = 'sepa.ownerName';

    /**
     * @var string
     */
    public const SEPA_IBAN_NUMBER_FIELD = 'sepa.ibanNumber';

    /**
     * @var string
     */
    public const BILLING_ADDRESS_FIELD = 'billingAddress';

    /**
     * @var string
     */
    public const DELIVERY_ADDRESS_FIELD = 'deliveryAddress';

    /**
     * @var string
     */
    public const PERSONAL_DETAILS_FIELD = 'personalDetails';

    /**
     * @var string
     */
    public const IDEAL_ISSUER_FIELD = 'idealIssuer';

    /**
     * @var string
     */
    public const REDIRECT_RESULT_FIELD = 'redirectResult';
}
