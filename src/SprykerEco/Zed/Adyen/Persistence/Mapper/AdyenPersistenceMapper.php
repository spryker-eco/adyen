<?php

/**
 * MIT License
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerEco\Zed\Adyen\Persistence\Mapper;

use Generated\Shared\Transfer\PaymentAdyenApiLogTransfer;
use Generated\Shared\Transfer\PaymentAdyenOrderItemTransfer;
use Generated\Shared\Transfer\PaymentAdyenTransfer;
use Generated\Shared\Transfer\SpyPaymentAdyenApiLogEntityTransfer;
use Generated\Shared\Transfer\SpyPaymentAdyenEntityTransfer;
use Generated\Shared\Transfer\SpyPaymentAdyenOrderItemEntityTransfer;

class AdyenPersistenceMapper implements AdyenPersistenceMapperInterface
{
    /**
     * @param \Generated\Shared\Transfer\PaymentAdyenTransfer $paymentAdyenTransfer
     *
     * @return \Generated\Shared\Transfer\SpyPaymentAdyenEntityTransfer
     */
    public function mapPaymentAdyenTransferToEntityTransfer(
        PaymentAdyenTransfer $paymentAdyenTransfer
    ): SpyPaymentAdyenEntityTransfer {
        $paymentAdyenEntityTransfer = (new SpyPaymentAdyenEntityTransfer())
            ->fromArray($paymentAdyenTransfer->modifiedToArray(), true);

        return $paymentAdyenEntityTransfer;
    }

    /**
     * @param \Generated\Shared\Transfer\SpyPaymentAdyenEntityTransfer $paymentAdyenEntityTransfer
     * @param \Generated\Shared\Transfer\PaymentAdyenTransfer $paymentAdyenTransfer
     *
     * @return \Generated\Shared\Transfer\PaymentAdyenTransfer
     */
    public function mapEntityTransferToPaymentAdyenTransfer(
        SpyPaymentAdyenEntityTransfer $paymentAdyenEntityTransfer,
        PaymentAdyenTransfer $paymentAdyenTransfer
    ): PaymentAdyenTransfer {
        $paymentAdyenTransfer->fromArray($paymentAdyenEntityTransfer->toArray(), true);

        return $paymentAdyenTransfer;
    }

    /**
     * @param \Generated\Shared\Transfer\PaymentAdyenOrderItemTransfer $paymentAdyenOrderItemTransfer
     *
     * @return \Generated\Shared\Transfer\SpyPaymentAdyenOrderItemEntityTransfer
     */
    public function mapPaymentAdyenOrderItemTransferToEntityTransfer(
        PaymentAdyenOrderItemTransfer $paymentAdyenOrderItemTransfer
    ): SpyPaymentAdyenOrderItemEntityTransfer {
        $paymentAdyenOrderItemEntityTransfer = (new SpyPaymentAdyenOrderItemEntityTransfer())
            ->fromArray($paymentAdyenOrderItemTransfer->modifiedToArray(), true);

        return $paymentAdyenOrderItemEntityTransfer;
    }

    /**
     * @param \Generated\Shared\Transfer\SpyPaymentAdyenOrderItemEntityTransfer $paymentAdyenOrderItemEntityTransfer
     * @param \Generated\Shared\Transfer\PaymentAdyenOrderItemTransfer $paymentAdyenOrderItemTransfer
     *
     * @return \Generated\Shared\Transfer\PaymentAdyenOrderItemTransfer
     */
    public function mapEntityTransferToPaymentAdyenOrderItemTransfer(
        SpyPaymentAdyenOrderItemEntityTransfer $paymentAdyenOrderItemEntityTransfer,
        PaymentAdyenOrderItemTransfer $paymentAdyenOrderItemTransfer
    ): PaymentAdyenOrderItemTransfer {
        $paymentAdyenOrderItemTransfer->fromArray(
            $paymentAdyenOrderItemEntityTransfer->toArray(),
            true
        );

        return $paymentAdyenOrderItemTransfer;
    }

    /**
     * @param \Generated\Shared\Transfer\PaymentAdyenApiLogTransfer $paymentAdyenApiLogTransfer
     *
     * @return \Generated\Shared\Transfer\SpyPaymentAdyenApiLogEntityTransfer
     */
    public function mapPaymentAdyenApiLogTransferToEntityTransfer(
        PaymentAdyenApiLogTransfer $paymentAdyenApiLogTransfer
    ): SpyPaymentAdyenApiLogEntityTransfer {
        $paymentAdyenApiLogEntityTransfer = (new SpyPaymentAdyenApiLogEntityTransfer())
            ->fromArray($paymentAdyenApiLogTransfer->modifiedToArray(), true);

        return $paymentAdyenApiLogEntityTransfer;
    }

    /**
     * @param \Generated\Shared\Transfer\SpyPaymentAdyenApiLogEntityTransfer $paymentAdyenApiLogEntityTransfer
     * @param \Generated\Shared\Transfer\PaymentAdyenApiLogTransfer $paymentAdyenApiLogTransfer
     *
     * @return \Generated\Shared\Transfer\PaymentAdyenApiLogTransfer
     */
    public function mapEntityTransferToPaymentAdyenApiLogTransfer(
        SpyPaymentAdyenApiLogEntityTransfer $paymentAdyenApiLogEntityTransfer,
        PaymentAdyenApiLogTransfer $paymentAdyenApiLogTransfer
    ): PaymentAdyenApiLogTransfer {
        $paymentAdyenApiLogTransfer->fromArray(
            $paymentAdyenApiLogEntityTransfer->toArray(),
            true
        );

        return $paymentAdyenApiLogTransfer;
    }
}
