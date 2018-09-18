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
}
