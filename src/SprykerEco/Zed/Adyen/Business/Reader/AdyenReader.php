<?php

/**
 * MIT License
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerEco\Zed\Adyen\Business\Reader;

use Generated\Shared\Transfer\OrderTransfer;
use Generated\Shared\Transfer\PaymentAdyenTransfer;
use Orm\Zed\Sales\Persistence\SpySalesOrderItem;
use SprykerEco\Zed\Adyen\Persistence\AdyenRepositoryInterface;

class AdyenReader implements AdyenReaderInterface
{
    /**
     * @var \SprykerEco\Zed\Adyen\Persistence\AdyenRepositoryInterface
     */
    protected $repository;

    /**
     * @param \SprykerEco\Zed\Adyen\Persistence\AdyenRepositoryInterface $repository
     */
    public function __construct(AdyenRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param \Generated\Shared\Transfer\OrderTransfer $orderTransfer
     *
     * @return \Generated\Shared\Transfer\PaymentAdyenTransfer
     */
    public function getPaymentAdyenByOrderTransfer(OrderTransfer $orderTransfer): PaymentAdyenTransfer
    {
        return $this->repository->getPaymentAdyenByIdSalesOrder($orderTransfer->getIdSalesOrderOrFail());
    }

    /**
     * @param string $reference
     *
     * @return \Generated\Shared\Transfer\PaymentAdyenTransfer
     */
    public function getPaymentAdyenByReference(string $reference): PaymentAdyenTransfer
    {
        return $this->repository->getPaymentAdyenByReference($reference);
    }

    /**
     * @param string $pspReference
     *
     * @return \Generated\Shared\Transfer\PaymentAdyenTransfer
     */
    public function getPaymentAdyenByPspReference(string $pspReference): PaymentAdyenTransfer
    {
        return $this->repository->getPaymentAdyenByPspReference($pspReference);
    }

    /**
     * @param int $idSalesOrder
     *
     * @return \Generated\Shared\Transfer\PaymentAdyenOrderItemTransfer[]
     */
    public function getAllPaymentAdyenOrderItemsByIdSalesOrder(int $idSalesOrder): array
    {
        return $this->repository->getAllPaymentAdyenOrderItemsByIdSalesOrder($idSalesOrder);
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
            $orderItems,
        );

        return $this->repository->getOrderItemsByIdsSalesOrderItems($orderItemIds);
    }

    /**
     * @param \Orm\Zed\Sales\Persistence\SpySalesOrderItem[] $orderItems
     *
     * @return \Generated\Shared\Transfer\PaymentAdyenOrderItemTransfer[]
     */
    public function getRemainingPaymentAdyenOrderItems(array $orderItems): array
    {
        /** @var \Orm\Zed\Sales\Persistence\SpySalesOrderItem $orderItem */
        $orderItem = reset($orderItems);

        $orderItemIds = array_map(
            function (SpySalesOrderItem $orderItem) {
                return $orderItem->getIdSalesOrderItem();
            },
            $orderItems,
        );

        return $this->repository->getRemainingPaymentAdyenOrderItems($orderItem->getFkSalesOrder(), $orderItemIds);
    }

    /**
     * @param \Orm\Zed\Sales\Persistence\SpySalesOrderItem[] $orderItems
     *
     * @return int[]
     */
    public function getRemainingSalesOrderItemIds(array $orderItems): array
    {
        /** @var \Orm\Zed\Sales\Persistence\SpySalesOrderItem $orderItem */
        $orderItem = reset($orderItems);

        $orderItemIds = array_map(
            function (SpySalesOrderItem $orderItem) {
                return $orderItem->getIdSalesOrderItem();
            },
            $orderItems,
        );

        return $this->repository->getRemainingSalesOrderItemIds($orderItem->getFkSalesOrder(), $orderItemIds);
    }
}
