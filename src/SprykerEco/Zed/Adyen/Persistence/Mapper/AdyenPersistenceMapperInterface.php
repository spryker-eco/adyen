<?php

/**
 * MIT License
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerEco\Zed\Adyen\Persistence\Mapper;

use Generated\Shared\Transfer\PaymentAdyenApiLogTransfer;
use Generated\Shared\Transfer\PaymentAdyenNotificationsTransfer;
use Generated\Shared\Transfer\PaymentAdyenNotificationTransfer;
use Generated\Shared\Transfer\PaymentAdyenOrderItemTransfer;
use Generated\Shared\Transfer\PaymentAdyenTransfer;
use Generated\Shared\Transfer\SpyPaymentAdyenApiLogEntityTransfer;
use Generated\Shared\Transfer\SpyPaymentAdyenEntityTransfer;
use Generated\Shared\Transfer\SpyPaymentAdyenNotificationEntityTransfer;
use Generated\Shared\Transfer\SpyPaymentAdyenNotificationsEntityTransfer;
use Generated\Shared\Transfer\SpyPaymentAdyenOrderItemEntityTransfer;

interface AdyenPersistenceMapperInterface
{
    /**
     * @param \Generated\Shared\Transfer\PaymentAdyenTransfer $paymentAdyenTransfer
     *
     * @return \Generated\Shared\Transfer\SpyPaymentAdyenEntityTransfer
     */
    public function mapPaymentAdyenTransferToEntityTransfer(
        PaymentAdyenTransfer $paymentAdyenTransfer
    ): SpyPaymentAdyenEntityTransfer;

    /**
     * @param \Generated\Shared\Transfer\SpyPaymentAdyenEntityTransfer $paymentAdyenEntityTransfer
     * @param \Generated\Shared\Transfer\PaymentAdyenTransfer $paymentAdyenTransfer
     *
     * @return \Generated\Shared\Transfer\PaymentAdyenTransfer
     */
    public function mapEntityTransferToPaymentAdyenTransfer(
        SpyPaymentAdyenEntityTransfer $paymentAdyenEntityTransfer,
        PaymentAdyenTransfer $paymentAdyenTransfer
    ): PaymentAdyenTransfer;

    /**
     * @param \Generated\Shared\Transfer\PaymentAdyenOrderItemTransfer $paymentAdyenOrderItemTransfer
     *
     * @return \Generated\Shared\Transfer\SpyPaymentAdyenOrderItemEntityTransfer
     */
    public function mapPaymentAdyenOrderItemTransferToEntityTransfer(
        PaymentAdyenOrderItemTransfer $paymentAdyenOrderItemTransfer
    ): SpyPaymentAdyenOrderItemEntityTransfer;

    /**
     * @param \Generated\Shared\Transfer\SpyPaymentAdyenOrderItemEntityTransfer $paymentAdyenOrderItemEntityTransfer
     * @param \Generated\Shared\Transfer\PaymentAdyenOrderItemTransfer $paymentAdyenOrderItemTransfer
     *
     * @return \Generated\Shared\Transfer\PaymentAdyenOrderItemTransfer
     */
    public function mapEntityTransferToPaymentAdyenOrderItemTransfer(
        SpyPaymentAdyenOrderItemEntityTransfer $paymentAdyenOrderItemEntityTransfer,
        PaymentAdyenOrderItemTransfer $paymentAdyenOrderItemTransfer
    ): PaymentAdyenOrderItemTransfer;

    /**
     * @param \Generated\Shared\Transfer\PaymentAdyenApiLogTransfer $paymentAdyenApiLogTransfer
     *
     * @return \Generated\Shared\Transfer\SpyPaymentAdyenApiLogEntityTransfer
     */
    public function mapPaymentAdyenApiLogTransferToEntityTransfer(
        PaymentAdyenApiLogTransfer $paymentAdyenApiLogTransfer
    ): SpyPaymentAdyenApiLogEntityTransfer;

    /**
     * @param \Generated\Shared\Transfer\SpyPaymentAdyenApiLogEntityTransfer $paymentAdyenApiLogEntityTransfer
     * @param \Generated\Shared\Transfer\PaymentAdyenApiLogTransfer $paymentAdyenApiLogTransfer
     *
     * @return \Generated\Shared\Transfer\PaymentAdyenApiLogTransfer
     */
    public function mapEntityTransferToPaymentAdyenApiLogTransfer(
        SpyPaymentAdyenApiLogEntityTransfer $paymentAdyenApiLogEntityTransfer,
        PaymentAdyenApiLogTransfer $paymentAdyenApiLogTransfer
    ): PaymentAdyenApiLogTransfer;

    /**
     * @param \Generated\Shared\Transfer\PaymentAdyenNotificationTransfer $paymentAdyenNotificationTransfer
     *
     * @return \Generated\Shared\Transfer\SpyPaymentAdyenNotificationEntityTransfer
     */
    public function mapPaymentAdyenNotificationTransferToEntityTransfer(
        PaymentAdyenNotificationTransfer $paymentAdyenNotificationTransfer
    ): SpyPaymentAdyenNotificationEntityTransfer;

    /**
     * @param \Generated\Shared\Transfer\SpyPaymentAdyenNotificationEntityTransfer $paymentAdyenNotificationEntityTransfer
     * @param \Generated\Shared\Transfer\PaymentAdyenNotificationTransfer $paymentAdyenNotificationTransfer
     *
     * @return \Generated\Shared\Transfer\PaymentAdyenNotificationTransfer
     */
    public function mapEntityTransferToPaymentAdyenNotificationTransfer(
        SpyPaymentAdyenNotificationEntityTransfer $paymentAdyenNotificationEntityTransfer,
        PaymentAdyenNotificationTransfer $paymentAdyenNotificationTransfer
    ): PaymentAdyenNotificationTransfer;
}
