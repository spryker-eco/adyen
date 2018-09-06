<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Zed\Adyen\Persistence;

use Generated\Shared\Transfer\PaymentAdyenApiLogTransfer;
use Generated\Shared\Transfer\PaymentAdyenOrderItemTransfer;
use Generated\Shared\Transfer\PaymentAdyenTransfer;
use Generated\Shared\Transfer\SpyPaymentAdyenApiLogEntityTransfer;
use Generated\Shared\Transfer\SpyPaymentAdyenEntityTransfer;
use Generated\Shared\Transfer\SpyPaymentAdyenOrderItemEntityTransfer;
use Spryker\Zed\Kernel\Persistence\AbstractEntityManager;
use SprykerEco\Zed\Adyen\Persistence\Mapper\AdyenPersistenceMapperInterface;

/**
 * @method \SprykerEco\Zed\Adyen\Persistence\AdyenPersistenceFactory getFactory()
 */
class AdyenEntityManager extends AbstractEntityManager implements AdyenEntityManagerInterface
{
    /**
     * @param \Generated\Shared\Transfer\PaymentAdyenTransfer $paymentAdyenTransfer
     *
     * @return \Generated\Shared\Transfer\PaymentAdyenTransfer
     */
    public function savePaymentAdyen(PaymentAdyenTransfer $paymentAdyenTransfer): PaymentAdyenTransfer
    {
        $entityTransfer = $this
            ->getMapper()
            ->mapPaymentAdyenTransferToEntityTransfer(
                $paymentAdyenTransfer,
                new SpyPaymentAdyenEntityTransfer()
            );

        $entityTransfer = $this->save($entityTransfer);

        $paymentAdyenTransfer = $this
            ->getMapper()
            ->mapEntityTransferToPaymentAdyenTransfer(
                $entityTransfer,
                $paymentAdyenTransfer
            );

        return $paymentAdyenTransfer;
    }

    /**
     * @param \Generated\Shared\Transfer\PaymentAdyenOrderItemTransfer $paymentAdyenOrderItemTransfer
     *
     * @return \Generated\Shared\Transfer\PaymentAdyenOrderItemTransfer
     */
    public function savePaymentAdyenOrderItem(
        PaymentAdyenOrderItemTransfer $paymentAdyenOrderItemTransfer
    ): PaymentAdyenOrderItemTransfer {
        $entityTransfer = $this
            ->getMapper()
            ->mapPaymentAdyenOrderItemTransferToEntityTransfer(
                $paymentAdyenOrderItemTransfer,
                new SpyPaymentAdyenOrderItemEntityTransfer()
            );

        $entityTransfer = $this->save($entityTransfer);

        $paymentAdyenOrderItemTransfer = $this
            ->getMapper()
            ->mapEntityTransferToPaymentAdyenOrderItemTransfer(
                $entityTransfer,
                $paymentAdyenOrderItemTransfer
            );

        return $paymentAdyenOrderItemTransfer;
    }

    /**
     * @param \Generated\Shared\Transfer\PaymentAdyenApiLogTransfer $paymentAdyenApiLogTransfer
     *
     * @return \Generated\Shared\Transfer\PaymentAdyenApiLogTransfer
     */
    public function savePaymentAdyenApiLog(
        PaymentAdyenApiLogTransfer $paymentAdyenApiLogTransfer
    ): PaymentAdyenApiLogTransfer {
        $entityTransfer = $this
            ->getMapper()
            ->mapPaymentAdyenApiLogTransferToEntityTransfer(
                $paymentAdyenApiLogTransfer,
                new SpyPaymentAdyenApiLogEntityTransfer()
            );

        $entityTransfer = $this->save($entityTransfer);

        $paymentAdyenApiLogTransfer = $this
            ->getMapper()
            ->mapEntityTransferToPaymentAdyenApiLogTransfer(
                $entityTransfer,
                $paymentAdyenApiLogTransfer
            );

        return $paymentAdyenApiLogTransfer;
    }

    /**
     * @return \SprykerEco\Zed\Adyen\Persistence\Mapper\AdyenPersistenceMapperInterface
     */
    protected function getMapper(): AdyenPersistenceMapperInterface
    {
        return $this->getFactory()->createAdyenPersistenceMapper();
    }
}
