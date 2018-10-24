<?php

/**
 * MIT License
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerEco\Zed\Adyen\Persistence;

use Generated\Shared\Transfer\PaymentAdyenApiLogTransfer;
use Generated\Shared\Transfer\PaymentAdyenNotificationTransfer;
use Generated\Shared\Transfer\PaymentAdyenOrderItemTransfer;
use Generated\Shared\Transfer\PaymentAdyenTransfer;
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
            ->mapPaymentAdyenTransferToEntityTransfer($paymentAdyenTransfer);

        /** @var \Generated\Shared\Transfer\SpyPaymentAdyenEntityTransfer $entityTransfer */
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
            ->mapPaymentAdyenOrderItemTransferToEntityTransfer($paymentAdyenOrderItemTransfer);

        /** @var \Generated\Shared\Transfer\SpyPaymentAdyenOrderItemEntityTransfer $entityTransfer */
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
            ->mapPaymentAdyenApiLogTransferToEntityTransfer($paymentAdyenApiLogTransfer);

        /** @var \Generated\Shared\Transfer\SpyPaymentAdyenApiLogEntityTransfer $entityTransfer */
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
     * @param \Generated\Shared\Transfer\PaymentAdyenNotificationTransfer $paymentAdyenNotificationTransfer
     *
     * @return \Generated\Shared\Transfer\PaymentAdyenNotificationTransfer
     */
    public function savePaymentAdyenNotification(
        PaymentAdyenNotificationTransfer $paymentAdyenNotificationTransfer
    ): PaymentAdyenNotificationTransfer {
        $entityTransfer = $this
            ->getMapper()
            ->mapPaymentAdyenNotificationTransferToEntityTransfer($paymentAdyenNotificationTransfer);

        /** @var \Generated\Shared\Transfer\SpyPaymentAdyenNotificationEntityTransfer $entityTransfer */
        $entityTransfer = $this->save($entityTransfer);

        $paymentAdyenNotificationTransfer = $this
            ->getMapper()
            ->mapEntityTransferToPaymentAdyenNotificationTransfer(
                $entityTransfer,
                $paymentAdyenNotificationTransfer
            );

        return $paymentAdyenNotificationTransfer;
    }

    /**
     * @return \SprykerEco\Zed\Adyen\Persistence\Mapper\AdyenPersistenceMapperInterface
     */
    protected function getMapper(): AdyenPersistenceMapperInterface
    {
        return $this->getFactory()->createAdyenPersistenceMapper();
    }
}
