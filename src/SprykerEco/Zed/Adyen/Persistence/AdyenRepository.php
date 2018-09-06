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
     * @param string $reference
     *
     * @param null $orderId
     *
     * @return \Generated\Shared\Transfer\PaymentAdyenOrderItemTransfer[]
     */
    public function getOrderItemsByReferenceAndOrderId(string $reference, $orderId = null): array
    {
        $query = $this
            ->getPaymentAdyenOrderItemQuery()
            ->useSpyPaymentAdyenQuery()
            ->filterByReference($reference)
            ->endUse();

        if ($orderId !== null) {
            $query->filterByFkSalesOrderItem($orderId);
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
