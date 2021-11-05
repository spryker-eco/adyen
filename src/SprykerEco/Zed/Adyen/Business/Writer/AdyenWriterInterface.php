<?php

/**
 * MIT License
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerEco\Zed\Adyen\Business\Writer;

use Generated\Shared\Transfer\AdyenApiRequestTransfer;
use Generated\Shared\Transfer\AdyenApiResponseTransfer;
use Generated\Shared\Transfer\AdyenNotificationsTransfer;
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
    public function savePaymentEntities(PaymentTransfer $paymentTransfer, SaveOrderTransfer $saveOrderTransfer): void;

    /**
     * @param string $status
     * @param array<\Generated\Shared\Transfer\PaymentAdyenOrderItemTransfer> $paymentAdyenOrderItemTransfers
     * @param \Generated\Shared\Transfer\PaymentAdyenTransfer|null $paymentAdyenTransfer
     *
     * @return void
     */
    public function updatePaymentEntities(
        string $status,
        array $paymentAdyenOrderItemTransfers,
        ?PaymentAdyenTransfer $paymentAdyenTransfer = null
    ): void;

    /**
     * @param string $type
     * @param \Generated\Shared\Transfer\AdyenApiRequestTransfer $request
     * @param \Generated\Shared\Transfer\AdyenApiResponseTransfer $response
     *
     * @return \Generated\Shared\Transfer\PaymentAdyenApiLogTransfer
     */
    public function saveApiLog(
        string $type,
        AdyenApiRequestTransfer $request,
        AdyenApiResponseTransfer $response
    ): PaymentAdyenApiLogTransfer;

    /**
     * @param \Generated\Shared\Transfer\AdyenNotificationsTransfer $adyenNotificationsTransfer
     *
     * @return void
     */
    public function saveNotifications(AdyenNotificationsTransfer $adyenNotificationsTransfer): void;
}
