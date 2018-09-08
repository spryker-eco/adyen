<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Zed\Adyen\Persistence;

use Generated\Shared\Transfer\PaymentAdyenOrderItemTransfer;
use Generated\Shared\Transfer\PaymentAdyenTransfer;
use Orm\Zed\Adyen\Persistence\SpyPaymentAdyenOrderItemQuery;
use Orm\Zed\Adyen\Persistence\SpyPaymentAdyenQuery;
use Spryker\Zed\Kernel\Persistence\AbstractRepository;

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
     * @param string $reference
     * @param int|null $idOrderItem
     *
     * @return \Generated\Shared\Transfer\PaymentAdyenOrderItemTransfer[]
     */
    public function getOrderItemsByReferenceAndIdOrderItem(string $reference, $idOrderItem = null): array
    {
        $query = $this
            ->getPaymentAdyenOrderItemQuery()
            ->useSpyPaymentAdyenQuery()
            ->filterByReference($reference)
            ->endUse();

        if ($idOrderItem !== null) {
            $query->filterByFkSalesOrderItem($idOrderItem);
        }

        $entityTransfers = $this->buildQueryFromCriteria($query)->find();

        $mapper = $result[] = $this->getFactory()->createAdyenPersistenceMapper();
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

        $mapper = $result[] = $this->getFactory()->createAdyenPersistenceMapper();
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
}
