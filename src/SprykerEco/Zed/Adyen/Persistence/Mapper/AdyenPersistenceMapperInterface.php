<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Zed\Adyen\Persistence\Mapper;

use Generated\Shared\Transfer\PaymentAdyenApiLogTransfer;
use Generated\Shared\Transfer\PaymentAdyenOrderItemTransfer;
use Generated\Shared\Transfer\PaymentAdyenTransfer;
use Generated\Shared\Transfer\SpyPaymentAdyenApiLogEntityTransfer;
use Generated\Shared\Transfer\SpyPaymentAdyenEntityTransfer;
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
}
