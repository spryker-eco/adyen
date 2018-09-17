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
     * @param int $idSalesOrder
     *
     * @return \Generated\Shared\Transfer\PaymentAdyenTransfer
     */
    public function getPaymentAdyenByIdSalesOrder(int $idSalesOrder): PaymentAdyenTransfer;

    /**
     * @param int $idSalesOrder
     *
     * @return \Generated\Shared\Transfer\PaymentAdyenOrderItemTransfer[]
     */
    public function getAllPaymentAdyenOrderItemsByIdSalesOrder(int $idSalesOrder): array;

    /**
     * @param int[] $orderItemIds
     *
     * @return \Generated\Shared\Transfer\PaymentAdyenOrderItemTransfer[]
     */
    public function getOrderItemsByIdsSalesOrderItems(array $orderItemIds): array;

    /**
     * @param int $idSalesOrder
     * @param int[] $orderItemIds
     *
     * @return \Generated\Shared\Transfer\PaymentAdyenOrderItemTransfer[]
     */
    public function getRemainingPaymentAdyenOrderItems(int $idSalesOrder, array $orderItemIds): array;

    /**
     * @param int $idSalesOrder
     * @param int[] $orderItemIds
     *
     * @return int[]
     */
    public function getRemainingSalesOrderItemIds(int $idSalesOrder, array $orderItemIds): array;
}
