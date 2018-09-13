<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Zed\Adyen\Business\Hook\Saver\MakePayment;

use Generated\Shared\Transfer\AdyenApiRequestTransfer;
use Generated\Shared\Transfer\AdyenApiResponseTransfer;

class SofortSaver extends AbstractSaver implements AdyenSaverInterface
{
    protected const MAKE_PAYMENT_SOFORT_REQUEST_TYPE = 'MakePayment[Sofort]';

    /**
     * @return string
     */
    protected function getRequestType(): string
    {
        return static::MAKE_PAYMENT_SOFORT_REQUEST_TYPE;
    }

    /**
     * @param \Generated\Shared\Transfer\AdyenApiRequestTransfer $request
     * @param \Generated\Shared\Transfer\AdyenApiResponseTransfer $response
     *
     * @return void
     */
    public function save(AdyenApiRequestTransfer $request, AdyenApiResponseTransfer $response): void
    {
        if ($response->getIsSuccess()) {
            $this->updateEntities($request, $response);
        }

        $this->log($request, $response);
    }

    /**
     * @param \Generated\Shared\Transfer\AdyenApiRequestTransfer $request
     * @param \Generated\Shared\Transfer\AdyenApiResponseTransfer $response
     *
     * @return void
     */
    protected function updateEntities(AdyenApiRequestTransfer $request, AdyenApiResponseTransfer $response): void
    {
        $paymentAdyenTransfer = $this->reader
            ->getPaymentAdyenByReference(
                $request->getMakePaymentRequest()->getReference()
            );

        $paymentAdyenTransfer->setDetails($response->getMakePaymentResponse()->getDetails());
        $paymentAdyenTransfer->setPaymentData($response->getMakePaymentResponse()->getPaymentData());

        $paymentAdyenOrderItemTransfers = $this->reader
            ->getAllPaymentAdyenOrderItemsByIdSalesOrder(
                $paymentAdyenTransfer->getFkSalesOrder()
            );

        $this->writer->update(
            $this->config->getOmsStatusNew(),
            $paymentAdyenOrderItemTransfers,
            $paymentAdyenTransfer
        );
    }
}
