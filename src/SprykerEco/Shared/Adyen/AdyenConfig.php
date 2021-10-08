<?php

/**
 * MIT License
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerEco\Shared\Adyen;

use Spryker\Shared\Kernel\AbstractBundleConfig;

class AdyenConfig extends AbstractBundleConfig
{
    /**
     * @var string
     */
    public const PROVIDER_NAME = 'Adyen';

    /**
     * @var string
     */
    public const ADYEN_CREDIT_CARD = 'adyenCreditCard';

    /**
     * @var string
     */
    public const ADYEN_SOFORT = 'adyenSofort';

    /**
     * @var string
     */
    public const ADYEN_DIRECT_DEBIT = 'adyenDirectDebit';

    /**
     * @var string
     */
    public const ADYEN_KLARNA_INVOICE = 'adyenKlarnaInvoice';

    /**
     * @var string
     */
    public const ADYEN_PREPAYMENT = 'adyenPrepayment';

    /**
     * @var string
     */
    public const ADYEN_IDEAL = 'adyenIdeal';

    /**
     * @var string
     */
    public const ADYEN_PAY_PAL = 'adyenPayPal';

    /**
     * @var string
     */
    public const ADYEN_ALI_PAY = 'adyenAliPay';

    /**
     * @var string
     */
    public const ADYEN_WE_CHAT_PAY = 'adyenWeChatPay';
}
