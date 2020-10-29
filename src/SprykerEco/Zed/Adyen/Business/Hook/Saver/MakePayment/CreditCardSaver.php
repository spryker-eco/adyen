<?php

/**
 * MIT License
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerEco\Zed\Adyen\Business\Hook\Saver\MakePayment;

use Generated\Shared\Transfer\AdyenApiResponseTransfer;
use Generated\Shared\Transfer\PaymentAdyenTransfer;

class CreditCardSaver extends AbstractSaver
{
    protected const MAKE_PAYMENT_CREDIT_CARD_REQUEST_TYPE = 'MakePayment[CreditCard]';

    /**
     * @return string
     */
    protected function getRequestType(): string
    {
        return static::MAKE_PAYMENT_CREDIT_CARD_REQUEST_TYPE;
    }

    /**
     * @param \Generated\Shared\Transfer\AdyenApiResponseTransfer $response
     * @param \Generated\Shared\Transfer\PaymentAdyenTransfer $paymentAdyenTransfer
     *
     * @return \Generated\Shared\Transfer\PaymentAdyenTransfer
     */
    protected function updatePaymentAdyenTransfer(
        AdyenApiResponseTransfer $response,
        PaymentAdyenTransfer $paymentAdyenTransfer
    ): PaymentAdyenTransfer {
        $paymentAdyenTransfer->setPspReference($response->getMakePaymentResponse()->getPspReference());

        if ($this->config->isCreditCard3dSecureEnabled()) {
            $paymentAdyenTransfer->setPaymentData($response->getMakePaymentResponse()->getPaymentData());
        }

        return $paymentAdyenTransfer;
    }

    /**
     * @param \Generated\Shared\Transfer\PaymentAdyenTransfer|null $paymentAdyenTransfer
     *
     * @return string
     */
    protected function getPaymentStatus(PaymentAdyenTransfer $paymentAdyenTransfer = null): string
    {
        if ($paymentAdyenTransfer) {
            if ($paymentAdyenTransfer->getResultCode() === $this->config->getOmsStatusRefused())
             return $this->config->getOmsStatusRefused();
        }

        return $this->config->getOmsStatusAuthorized();
    }
}
