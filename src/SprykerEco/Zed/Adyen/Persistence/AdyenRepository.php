<?php

/**
 * MIT License
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerEco\Zed\Adyen\Persistence;

use Generated\Shared\Transfer\PaymentAdyenOrderItemTransfer;
use Generated\Shared\Transfer\PaymentAdyenTransfer;
use Generated\Shared\Transfer\SpySalesOrderItemEntityTransfer;
use Orm\Zed\Adyen\Persistence\SpyPaymentAdyenOrderItemQuery;
use Orm\Zed\Adyen\Persistence\SpyPaymentAdyenQuery;
use Orm\Zed\Sales\Persistence\SpySalesOrderItemQuery;
use Spryker\Zed\Kernel\Persistence\AbstractRepository;
use Spryker\Zed\PropelOrm\Business\Runtime\ActiveQuery\Criteria;

/**
 * @method \SprykerEco\Zed\Adyen\Persistence\AdyenPersistenceFactory getFactory()
 */
class AdyenRepository extends AbstractRepository implements AdyenRepositoryInterface
{
    /**
     * @param string $reference
     *
     * @return \Generated\Shared\Transfer\PaymentAdyenTransfer
     */
    public function getPaymentAdyenByReference(string $reference): PaymentAdyenTransfer
    {
        $query = $this->getPaymentAdyenQuery()->filterByReference($reference);
        $entityTransfer = $this->buildQueryFromCriteria($query)->findOne();

        return $this->getFactory()
            ->createAdyenPersistenceMapper()
            ->mapEntityTransferToPaymentAdyenTransfer($entityTransfer, new PaymentAdyenTransfer());
    }

    /**
     * @param int $idSalesOrder
     *
     * @return \Generated\Shared\Transfer\PaymentAdyenTransfer
     */
    public function getPaymentAdyenByIdSalesOrder(int $idSalesOrder): PaymentAdyenTransfer
    {
        $query = $this->getPaymentAdyenQuery()->filterByFkSalesOrder($idSalesOrder);
        $entityTransfer = $this->buildQueryFromCriteria($query)->findOne();

        return $this->getFactory()
            ->createAdyenPersistenceMapper()
            ->mapEntityTransferToPaymentAdyenTransfer($entityTransfer, new PaymentAdyenTransfer());
    }

    /**
     * @param int $idSalesOrder
     *
     * @return \Generated\Shared\Transfer\PaymentAdyenOrderItemTransfer[]
     */
    public function getAllPaymentAdyenOrderItemsByIdSalesOrder(int $idSalesOrder): array
    {
        $query = $this
            ->getPaymentAdyenOrderItemQuery()
            ->useSpyPaymentAdyenQuery()
            ->filterByFkSalesOrder($idSalesOrder)
            ->endUse();

        $entityTransfers = $this->buildQueryFromCriteria($query)->find();

        $mapper = $this->getFactory()->createAdyenPersistenceMapper();
        $result = [];

        foreach ($entityTransfers as $entityTransfer) {
            $result[] = $mapper
                ->mapEntityTransferToPaymentAdyenOrderItemTransfer(
                    $entityTransfer,
                    new PaymentAdyenOrderItemTransfer()
                );
        }

        return $result;
    }

    /**
     * @param int[] $orderItemIds
     *
     * @return \Generated\Shared\Transfer\PaymentAdyenOrderItemTransfer[]
     */
    public function getOrderItemsByIdsSalesOrderItems(array $orderItemIds): array
    {
        $query = $this
            ->getPaymentAdyenOrderItemQuery()
            ->filterByFkSalesOrderItem_In($orderItemIds);

        $entityTransfers = $this->buildQueryFromCriteria($query)->find();

        $mapper = $this->getFactory()->createAdyenPersistenceMapper();
        $result = [];

        foreach ($entityTransfers as $entityTransfer) {
            $result[] = $mapper
                ->mapEntityTransferToPaymentAdyenOrderItemTransfer(
                    $entityTransfer,
                    new PaymentAdyenOrderItemTransfer()
                );
        }

        return $result;
    }

    /**
     * @param int $idSalesOrder
     * @param int[] $orderItemIds
     *
     * @return \Generated\Shared\Transfer\PaymentAdyenOrderItemTransfer[]
     */
    public function getRemainingPaymentAdyenOrderItems(int $idSalesOrder, array $orderItemIds): array
    {
        $query = $this
            ->getPaymentAdyenOrderItemQuery()
            ->filterByFkSalesOrderItem($orderItemIds, Criteria::NOT_IN)
            ->useSpyPaymentAdyenQuery()
            ->filterByFkSalesOrder($idSalesOrder)
            ->endUse();

        $entityTransfers = $this->buildQueryFromCriteria($query)->find();

        $mapper = $this->getFactory()->createAdyenPersistenceMapper();
        $result = [];

        foreach ($entityTransfers as $entityTransfer) {
            $result[] = $mapper
                ->mapEntityTransferToPaymentAdyenOrderItemTransfer(
                    $entityTransfer,
                    new PaymentAdyenOrderItemTransfer()
                );
        }

        return $result;
    }

    /**
     * @param int $idSalesOrder
     * @param int[] $orderItemIds
     *
     * @return int[]
     */
    public function getRemainingSalesOrderItemIds(int $idSalesOrder, array $orderItemIds): array
    {
        $query = $this
            ->getSalesOrderItemQuery()
            ->filterByIdSalesOrderItem($orderItemIds, Criteria::NOT_IN)
            ->useOrderQuery()
            ->filterByIdSalesOrder($idSalesOrder)
            ->endUse();

        $entityTransfers = $this->buildQueryFromCriteria($query)->find();

        $remainingOrderItemIds = array_map(
            function (SpySalesOrderItemEntityTransfer $entityTransfer) {
                return $entityTransfer->getIdSalesOrderItem();
            },
            $entityTransfers
        );

        return $remainingOrderItemIds;
    }

    /**
     * @return \Orm\Zed\Adyen\Persistence\SpyPaymentAdyenQuery
     */
    protected function getPaymentAdyenQuery(): SpyPaymentAdyenQuery
    {
        return $this->getFactory()->createPaymentAdyenQuery();
    }

    /**
     * @return \Orm\Zed\Adyen\Persistence\SpyPaymentAdyenOrderItemQuery
     */
    protected function getPaymentAdyenOrderItemQuery(): SpyPaymentAdyenOrderItemQuery
    {
        return $this->getFactory()->createPaymentAdyenOrderItemQuery();
    }

    /**
     * @return \Orm\Zed\Sales\Persistence\SpySalesOrderItemQuery
     */
    protected function getSalesOrderItemQuery(): SpySalesOrderItemQuery
    {
        return $this->getFactory()->createSpySalesOrderItemQuery();
    }
}
