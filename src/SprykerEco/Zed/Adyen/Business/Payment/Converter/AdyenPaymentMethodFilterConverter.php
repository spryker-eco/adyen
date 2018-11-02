<?php

/**
 * MIT License
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerEco\Zed\Adyen\Business\Payment\Converter;

use SprykerEco\Zed\Adyen\AdyenConfig;

class AdyenPaymentMethodFilterConverter implements AdyenPaymentMethodFilterConverterInterface
{
    /**
     * @var \SprykerEco\Zed\Adyen\AdyenConfig
     */
    protected $config;

    /**
     * @param \SprykerEco\Zed\Adyen\AdyenConfig $config
     */
    public function __construct(AdyenConfig $config)
    {
        $this->config = $config;
    }

    /**
     * @param \Generated\Shared\Transfer\AdyenApiPaymentMethodTransfer[] $paymentMethods
     *
     * @return string[]
     */
    public function getAvailablePaymentMethods(array $paymentMethods): array
    {
        $availablePaymentMethods = [];
        $methodsFromConfig = $this->config->getMapperPaymentMethods();

        foreach ($paymentMethods as $paymentMethod) {
            if (array_key_exists($paymentMethod->getType(), $methodsFromConfig)) {
                $availablePaymentMethods[] = $methodsFromConfig[$paymentMethod->getType()];
            }
        }

        return $availablePaymentMethods;
    }
}
