<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Shared\Adyen;

use Spryker\Shared\Kernel\AbstractBundleConfig;

class AdyenConfig extends AbstractBundleConfig
{
    public const PROVIDER_NAME = 'Adyen';
    public const ADYEN_CREDIT_CARD = 'adyenCreditCard';
    public const ADYEN_SOFORT = 'adyenSofort';
}
