<?php

/**
 * MIT License
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerEco\Zed\Adyen\Business\Hook\Saver\MakePayment;

use Generated\Shared\Transfer\AdyenApiResponseTransfer;
use Generated\Shared\Transfer\PaymentAdyenTransfer;

class DirectDebitSaver extends AbstractSaver
{
    /**
     * @var string
     */
    protected const MAKE_PAYMENT_DIRECT_DEBIT_REQUEST_TYPE = 'MakePayment[DirectDebit]';

    /**
     * @return string
     */
    protected function getRequestType(): string
    {
        return static::MAKE_PAYMENT_DIRECT_DEBIT_REQUEST_TYPE;
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
        $paymentAdyenTransfer->setAdditionalData(
            $this->encodingService->encodeJson($response->getMakePaymentResponseOrFail()->getAdditionalData())
        );

        $paymentAdyenTransfer->setPspReference($response->getMakePaymentResponseOrFail()->getPspReference());

        return $paymentAdyenTransfer;
    }
}
