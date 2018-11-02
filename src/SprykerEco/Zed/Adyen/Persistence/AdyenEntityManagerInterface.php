<?php

/**
 * MIT License
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerEco\Zed\Adyen\Persistence;

use Generated\Shared\Transfer\PaymentAdyenApiLogTransfer;
use Generated\Shared\Transfer\PaymentAdyenNotificationTransfer;
use Generated\Shared\Transfer\PaymentAdyenOrderItemTransfer;
use Generated\Shared\Transfer\PaymentAdyenTransfer;

interface AdyenEntityManagerInterface
{
    /**
     * @param \Generated\Shared\Transfer\PaymentAdyenTransfer $paymentAdyenTransfer
     *
     * @return \Generated\Shared\Transfer\PaymentAdyenTransfer
     */
    public function savePaymentAdyen(PaymentAdyenTransfer $paymentAdyenTransfer): PaymentAdyenTransfer;

    /**
     * @param \Generated\Shared\Transfer\PaymentAdyenOrderItemTransfer $paymentAdyenOrderItemTransfer
     *
     * @return \Generated\Shared\Transfer\PaymentAdyenOrderItemTransfer
     */
    public function savePaymentAdyenOrderItem(
        PaymentAdyenOrderItemTransfer $paymentAdyenOrderItemTransfer
    ): PaymentAdyenOrderItemTransfer;

    /**
     * @param \Generated\Shared\Transfer\PaymentAdyenApiLogTransfer $paymentAdyenApiLogTransfer
     *
     * @return \Generated\Shared\Transfer\PaymentAdyenApiLogTransfer
     */
    public function savePaymentAdyenApiLog(
        PaymentAdyenApiLogTransfer $paymentAdyenApiLogTransfer
    ): PaymentAdyenApiLogTransfer;

    /**
     * @param \Generated\Shared\Transfer\PaymentAdyenNotificationTransfer $paymentAdyenNotificationTransfer
     *
     * @return \Generated\Shared\Transfer\PaymentAdyenNotificationTransfer
     */
    public function savePaymentAdyenNotification(
        PaymentAdyenNotificationTransfer $paymentAdyenNotificationTransfer
    ): PaymentAdyenNotificationTransfer;
}
