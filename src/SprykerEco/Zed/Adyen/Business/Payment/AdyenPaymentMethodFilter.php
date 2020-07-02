<?php

/**
 * MIT License
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerEco\Zed\Adyen\Business\Payment;

use ArrayObject;
use Generated\Shared\Transfer\AdyenApiResponseTransfer;
use Generated\Shared\Transfer\PaymentMethodsTransfer;
use Generated\Shared\Transfer\PaymentMethodTransfer;
use Generated\Shared\Transfer\QuoteTransfer;
use SprykerEco\Zed\Adyen\Business\Payment\Converter\AdyenPaymentMethodFilterConverterInterface;
use SprykerEco\Zed\Adyen\Business\Payment\Mapper\AdyenPaymentMethodFilterMapperInterface;
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
     * @var \SprykerEco\Zed\Adyen\Business\Payment\Mapper\AdyenPaymentMethodFilterMapperInterface
     */
    protected $mapper;

    /**
     * @var \SprykerEco\Zed\Adyen\Business\Payment\Converter\AdyenPaymentMethodFilterConverterInterface
     */
    protected $converter;

    /**
     * @param \SprykerEco\Zed\Adyen\Dependency\Facade\AdyenToAdyenApiFacadeInterface $adyenApiFacade
     * @param \SprykerEco\Zed\Adyen\Business\Payment\Mapper\AdyenPaymentMethodFilterMapperInterface $mapper
     * @param \SprykerEco\Zed\Adyen\Business\Payment\Converter\AdyenPaymentMethodFilterConverterInterface $converter
     */
    public function __construct(
        AdyenToAdyenApiFacadeInterface $adyenApiFacade,
        AdyenPaymentMethodFilterMapperInterface $mapper,
        AdyenPaymentMethodFilterConverterInterface $converter
    ) {
        $this->adyenApiFacade = $adyenApiFacade;
        $this->mapper = $mapper;
        $this->converter = $converter;
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
        $this->availableMethods = $this->converter->getAvailablePaymentMethods(
            $this->getAvailablePaymentMethods($quoteTransfer)->getPaymentMethods()->getArrayCopy()
        );

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
     * @param \Generated\Shared\Transfer\QuoteTransfer $quoteTransfer
     *
     * @return \Generated\Shared\Transfer\AdyenApiResponseTransfer
     */
    public function getAvailablePaymentMethods(QuoteTransfer $quoteTransfer): AdyenApiResponseTransfer
    {
        $requestTransfer = $this->mapper->buildRequestTransfer($quoteTransfer);

        return $this->adyenApiFacade->performGetPaymentMethodsApiCall($requestTransfer);
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
