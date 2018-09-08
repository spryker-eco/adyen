<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Zed\Adyen\Business\Reader;

use Generated\Shared\Transfer\OrderTransfer;
use Generated\Shared\Transfer\PaymentAdyenTransfer;
use Orm\Zed\Sales\Persistence\SpySalesOrderItem;
use SprykerEco\Zed\Adyen\Persistence\AdyenRepositoryInterface;

class AdyenReader implements AdyenReaderInterface
{
    protected $repository;

    public function __construct(AdyenRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param \Generated\Shared\Transfer\OrderTransfer $orderTransfer
     *
     * @return \Generated\Shared\Transfer\PaymentAdyenTransfer
     */
    public function getPaymentAdyen(OrderTransfer $orderTransfer): PaymentAdyenTransfer
    {
        return $this->repository->getPaymentAdyenByIdSalesOrder($orderTransfer->getIdSalesOrder());
    }

    /**
     * @param \Orm\Zed\Sales\Persistence\SpySalesOrderItem[] $orderItems
     *
     * @return \Generated\Shared\Transfer\PaymentAdyenOrderItemTransfer[]
     */
    public function getPaymentAdyenOrderItemsByOrderItems(array $orderItems): array
    {
        $orderItemIds = array_map(
            function (SpySalesOrderItem $orderItem) {
                return $orderItem->getIdSalesOrderItem();
            },
            $orderItems
        );

        return $this->repository->getOrderItemsByIdsSalesOrderItems($orderItemIds);
    }
}
