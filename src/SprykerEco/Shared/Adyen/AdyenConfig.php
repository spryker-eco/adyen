<?php

/**
 * MIT License
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerEco\Shared\Adyen;

use Spryker\Shared\Kernel\AbstractBundleConfig;

class AdyenConfig extends AbstractBundleConfig
{
    public const PROVIDER_NAME = 'Adyen';
    public const ADYEN_CREDIT_CARD = 'adyenCreditCard';
    public const ADYEN_SOFORT = 'adyenSofort';
    public const ADYEN_DIRECT_DEBIT = 'adyenDirectDebit';
    public const ADYEN_KLARNA_INVOICE = 'adyenKlarnaInvoice';
    public const ADYEN_PREPAYMENT = 'adyenPrepayment';
    public const ADYEN_IDEAL = 'adyenIdeal';
    public const ADYEN_PAY_PAL = 'adyenPayPal';
    public const ADYEN_ALI_PAL = 'adyenAliPay';
}
