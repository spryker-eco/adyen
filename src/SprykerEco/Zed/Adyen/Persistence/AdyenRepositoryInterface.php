<?php

/**
 * MIT License
 * For full license information, please view the LICENSE file that was distributed with this source code.
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
     * @param string $pspReference
     *
     * @return \Generated\Shared\Transfer\PaymentAdyenTransfer
     */
    public function getPaymentAdyenByPspReference(string $pspReference): PaymentAdyenTransfer;

    /**
     * @param int $idSalesOrder
     *
     * @return array<\Generated\Shared\Transfer\PaymentAdyenOrderItemTransfer>
     */
    public function getAllPaymentAdyenOrderItemsByIdSalesOrder(int $idSalesOrder): array;

    /**
     * @param array<int> $orderItemIds
     *
     * @return array<\Generated\Shared\Transfer\PaymentAdyenOrderItemTransfer>
     */
    public function getOrderItemsByIdsSalesOrderItems(array $orderItemIds): array;

    /**
     * @param int $idSalesOrder
     * @param array<int> $orderItemIds
     *
     * @return array<\Generated\Shared\Transfer\PaymentAdyenOrderItemTransfer>
     */
    public function getRemainingPaymentAdyenOrderItems(int $idSalesOrder, array $orderItemIds): array;

    /**
     * @param int $idSalesOrder
     * @param array<int> $orderItemIds
     *
     * @return array<int>
     */
    public function getRemainingSalesOrderItemIds(int $idSalesOrder, array $orderItemIds): array;
}
