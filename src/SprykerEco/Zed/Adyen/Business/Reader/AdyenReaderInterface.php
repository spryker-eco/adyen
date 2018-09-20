<?php

/**
 * MIT License
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerEco\Zed\Adyen\Business\Reader;

use Generated\Shared\Transfer\OrderTransfer;
use Generated\Shared\Transfer\PaymentAdyenTransfer;

interface AdyenReaderInterface
{
    /**
     * @param \Generated\Shared\Transfer\OrderTransfer $orderTransfer
     *
     * @return \Generated\Shared\Transfer\PaymentAdyenTransfer
     */
    public function getPaymentAdyenByOrderTransfer(OrderTransfer $orderTransfer): PaymentAdyenTransfer;

    /**
     * @param string $reference
     *
     * @return \Generated\Shared\Transfer\PaymentAdyenTransfer
     */
    public function getPaymentAdyenByReference(string $reference): PaymentAdyenTransfer;

    /**
     * @param string $pspReference
     *
     * @return \Generated\Shared\Transfer\PaymentAdyenTransfer
     */
    public function getPaymentAdyenByPspReference(string $pspReference): PaymentAdyenTransfer;

    /**
     * @param int $idSalesOrder
     *
     * @return \Generated\Shared\Transfer\PaymentAdyenOrderItemTransfer[]
     */
    public function getAllPaymentAdyenOrderItemsByIdSalesOrder(int $idSalesOrder): array;

    /**
     * @param \Orm\Zed\Sales\Persistence\SpySalesOrderItem[] $orderItems
     *
     * @return \Generated\Shared\Transfer\PaymentAdyenOrderItemTransfer[]
     */
    public function getPaymentAdyenOrderItemsByOrderItems(array $orderItems): array;

    /**
     * @param \Orm\Zed\Sales\Persistence\SpySalesOrderItem[] $orderItems
     *
     * @return \Generated\Shared\Transfer\PaymentAdyenOrderItemTransfer[]
     */
    public function getRemainingPaymentAdyenOrderItems(array $orderItems): array;

    /**
     * @param \Orm\Zed\Sales\Persistence\SpySalesOrderItem[] $orderItems
     *
     * @return int[]
     */
    public function getRemainingSalesOrderItemIds(array $orderItems): array;
}
