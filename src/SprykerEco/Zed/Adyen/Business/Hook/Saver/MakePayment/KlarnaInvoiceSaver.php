<?php

/**
 * MIT License
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerEco\Zed\Adyen\Business\Hook\Saver\MakePayment;

use Generated\Shared\Transfer\AdyenApiResponseTransfer;
use Generated\Shared\Transfer\PaymentAdyenTransfer;

class KlarnaInvoiceSaver extends AbstractSaver
{
    protected const MAKE_PAYMENT_INVOICE_REQUEST_TYPE = 'MakePayment[KlarnaInvoice]';

    /**
     * @return string
     */
    protected function getRequestType(): string
    {
        return static::MAKE_PAYMENT_INVOICE_REQUEST_TYPE;
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

        return $paymentAdyenTransfer;
    }

    /**
     * @param \Generated\Shared\Transfer\PaymentAdyenTransfer|null $paymentAdyenTransfer
     *
     * @return string
     */
    protected function getPaymentStatus(?PaymentAdyenTransfer $paymentAdyenTransfer = null): string
    {
        return $this->config->getOmsStatusAuthorized();
    }
}
