<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Zed\Adyen\Business\Writer;

use Generated\Shared\Transfer\AdyenApiRequestTransfer;
use Generated\Shared\Transfer\AdyenApiResponseTransfer;
use Generated\Shared\Transfer\PaymentAdyenApiLogTransfer;
use Generated\Shared\Transfer\PaymentAdyenTransfer;
use Generated\Shared\Transfer\PaymentTransfer;
use Generated\Shared\Transfer\SaveOrderTransfer;

interface AdyenWriterInterface
{
    /**
     * @param \Generated\Shared\Transfer\PaymentTransfer $paymentTransfer
     * @param \Generated\Shared\Transfer\SaveOrderTransfer $saveOrderTransfer
     *
     * @return void
     */
    public function saveOrderPaymentEntities(PaymentTransfer $paymentTransfer, SaveOrderTransfer $saveOrderTransfer): void;

    /**
     * @param string $status
     * @param \Generated\Shared\Transfer\AdyenApiRequestTransfer $request
     * @param \Generated\Shared\Transfer\AdyenApiResponseTransfer $response
     *
     * @return void
     */
    public function updateOrderPaymentEntities(
        string $status,
        AdyenApiRequestTransfer $request,
        AdyenApiResponseTransfer $response
    ): void;

    /**
     * @param string $status
     * @param \Generated\Shared\Transfer\PaymentAdyenOrderItemTransfer[] $paymentAdyenOrderItemTransfers
     * @param \Generated\Shared\Transfer\PaymentAdyenTransfer $paymentAdyenTransfer
     *
     * @return void
     */
    public function update(
        string $status,
        array $paymentAdyenOrderItemTransfers,
        PaymentAdyenTransfer $paymentAdyenTransfer = null
    ): void;

    /**
     * @param string $type
     * @param \Generated\Shared\Transfer\AdyenApiRequestTransfer $request
     * @param \Generated\Shared\Transfer\AdyenApiResponseTransfer $response
     *
     * @return \Generated\Shared\Transfer\PaymentAdyenApiLogTransfer
     */
    public function savePaymentAdyenApiLog(
        string $type,
        AdyenApiRequestTransfer $request,
        AdyenApiResponseTransfer $response
    ): PaymentAdyenApiLogTransfer;
}
