<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Zed\Adyen\Business\Payment;

use ArrayObject;
use Generated\Shared\Transfer\PaymentMethodsTransfer;
use Generated\Shared\Transfer\PaymentMethodTransfer;
use Generated\Shared\Transfer\QuoteTransfer;
use SprykerEco\Zed\Adyen\Dependency\Facade\AdyenToAdyenApiFacadeInterface;

class AdyenPaymentMethodFilter implements AdyenPaymentMethodFilterInterface
{
    protected const ADYEN_PAYMENT_METHOD = 'adyen';

    /**
     * @var string[]
     */
    protected $availableMethods = [];

    /**
     * @var \SprykerEco\Zed\Adyen\Dependency\Facade\AdyenToAdyenApiFacadeInterface
     */
    protected $adyenApiFacade;

    /**
     * @param \SprykerEco\Zed\Adyen\Dependency\Facade\AdyenToAdyenApiFacadeInterface $adyenApiFacade
     */
    public function __construct(AdyenToAdyenApiFacadeInterface $adyenApiFacade)
    {
        $this->adyenApiFacade = $adyenApiFacade;
    }

    /**
     * @param \Generated\Shared\Transfer\PaymentMethodsTransfer $paymentMethodsTransfer
     * @param \Generated\Shared\Transfer\QuoteTransfer $quoteTransfer
     *
     * @return \Generated\Shared\Transfer\PaymentMethodsTransfer
     */
    public function filterPaymentMethods(
        PaymentMethodsTransfer $paymentMethodsTransfer,
        QuoteTransfer $quoteTransfer
    ): PaymentMethodsTransfer {
        $this->availableMethods = $this->getAvailablePaymentMethods();

        $result = new ArrayObject();

        foreach ($paymentMethodsTransfer->getMethods() as $paymentMethod) {
            if ($this->isPaymentProviderAdyen($paymentMethod) && !$this->isAvailable($paymentMethod)) {
                continue;
            }

            $result->append($paymentMethod);
        }

        $paymentMethodsTransfer->setMethods($result);

        return $paymentMethodsTransfer;
    }

    /**
     * @return string[]
     */
    protected function getAvailablePaymentMethods()
    {
        return [];
    }

    /**
     * @param \Generated\Shared\Transfer\PaymentMethodTransfer $paymentMethodTransfer
     *
     * @return bool
     */
    protected function isAvailable(PaymentMethodTransfer $paymentMethodTransfer): bool
    {
        return in_array($paymentMethodTransfer->getMethodName(), $this->availableMethods);
    }

    /**
     * @param \Generated\Shared\Transfer\PaymentMethodTransfer $paymentMethodTransfer
     *
     * @return bool
     */
    protected function isPaymentProviderAdyen(PaymentMethodTransfer $paymentMethodTransfer): bool
    {
        return strpos($paymentMethodTransfer->getMethodName(), static::ADYEN_PAYMENT_METHOD) !== false;
    }
}
