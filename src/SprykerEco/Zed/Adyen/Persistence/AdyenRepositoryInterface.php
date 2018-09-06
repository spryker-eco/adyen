<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Zed\Adyen\Persistence;

use Generated\Shared\Transfer\PaymentAdyenTransfer;

interface AdyenRepositoryInterface
{
    /**
     * @param string $reference
     *
     * @return \Generated\Shared\Transfer\PaymentAdyenTransfer
     */
    public function getPaymentAdyenByReference(string $reference): PaymentAdyenTransfer;

    /**
     * @param string $reference
     *
     * @param null $orderId
     *
     * @return \Generated\Shared\Transfer\PaymentAdyenOrderItemTransfer[]
     */
    public function getOrderItemsByReferenceAndOrderId(string $reference, $orderId = null): array;
}
