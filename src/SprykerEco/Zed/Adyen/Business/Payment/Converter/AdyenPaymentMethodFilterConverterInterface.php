<?php

/**
 * MIT License
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerEco\Zed\Adyen\Business\Payment\Converter;

interface AdyenPaymentMethodFilterConverterInterface
{
    /**
     * @param \Generated\Shared\Transfer\AdyenApiPaymentMethodTransfer[] $paymentMethods
     *
     * @return string[]
     */
    public function getAvailablePaymentMethods(array $paymentMethods): array;
}
