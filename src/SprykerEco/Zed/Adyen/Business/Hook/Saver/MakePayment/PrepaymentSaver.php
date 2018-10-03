<?php

/**
 * MIT License
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerEco\Zed\Adyen\Business\Hook\Saver\MakePayment;

use Generated\Shared\Transfer\AdyenApiRequestTransfer;
use Generated\Shared\Transfer\AdyenApiResponseTransfer;

class PrepaymentSaver extends AbstractSaver implements AdyenSaverInterface
{
    protected const MAKE_PAYMENT_PREPAYMENT_REQUEST_TYPE = 'MakePayment[Prepayment]';

    /**
     * @return string
     */
    protected function getRequestType(): string
    {
        return static::MAKE_PAYMENT_PREPAYMENT_REQUEST_TYPE;
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

        $paymentAdyenTransfer->setAdditionalData(
            $this->encodingService->encodeJson($response->getMakePaymentResponse()->getAdditionalData())
        );

        $paymentAdyenTransfer->setPspReference($response->getMakePaymentResponse()->getPspReference());

        $paymentAdyenOrderItemTransfers = $this->reader
            ->getAllPaymentAdyenOrderItemsByIdSalesOrder(
                $paymentAdyenTransfer->getFkSalesOrder()
            );

        $this->writer->updatePaymentEntities(
            $this->config->getOmsStatusAuthorized(),
            $paymentAdyenOrderItemTransfers,
            $paymentAdyenTransfer
        );
    }
}
