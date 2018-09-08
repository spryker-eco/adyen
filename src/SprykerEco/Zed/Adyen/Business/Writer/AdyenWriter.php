<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Zed\Adyen\Business\Writer;

use Generated\Shared\Transfer\AdyenApiRequestTransfer;
use Generated\Shared\Transfer\AdyenApiResponseTransfer;
use Generated\Shared\Transfer\ItemTransfer;
use Generated\Shared\Transfer\PaymentAdyenApiLogTransfer;
use Generated\Shared\Transfer\PaymentAdyenOrderItemTransfer;
use Generated\Shared\Transfer\PaymentAdyenTransfer;
use Generated\Shared\Transfer\PaymentTransfer;
use Generated\Shared\Transfer\SaveOrderTransfer;
use Spryker\Zed\Kernel\Persistence\EntityManager\TransactionTrait;
use SprykerEco\Zed\Adyen\AdyenConfig;
use SprykerEco\Zed\Adyen\Persistence\AdyenEntityManagerInterface;
use SprykerEco\Zed\Adyen\Persistence\AdyenRepositoryInterface;

class AdyenWriter implements AdyenWriterInterface
{
    use TransactionTrait;

    /**
     * @var \SprykerEco\Zed\Adyen\Persistence\AdyenRepositoryInterface
     */
    protected $repository;

    /**
     * @var \SprykerEco\Zed\Adyen\Persistence\AdyenEntityManagerInterface
     */
    protected $entityManager;

    /**
     * @var \SprykerEco\Zed\Adyen\AdyenConfig
     */
    protected $config;

    /**
     * @param \SprykerEco\Zed\Adyen\Persistence\AdyenRepositoryInterface $repository
     * @param \SprykerEco\Zed\Adyen\Persistence\AdyenEntityManagerInterface $entityManager
     * @param \SprykerEco\Zed\Adyen\AdyenConfig $config
     */
    public function __construct(
        AdyenRepositoryInterface $repository,
        AdyenEntityManagerInterface $entityManager,
        AdyenConfig $config
    ) {
        $this->repository = $repository;
        $this->entityManager = $entityManager;
        $this->config = $config;
    }

    /**
     * @param \Generated\Shared\Transfer\PaymentTransfer $paymentTransfer
     * @param \Generated\Shared\Transfer\SaveOrderTransfer $saveOrderTransfer
     *
     * @return void
     */
    public function saveOrderPaymentEntities(PaymentTransfer $paymentTransfer, SaveOrderTransfer $saveOrderTransfer): void
    {
        $paymentAdyenTransfer = $this->savePaymentAdyen($paymentTransfer, $saveOrderTransfer);

        foreach ($saveOrderTransfer->getOrderItems() as $orderItem) {
            $this->savePaymentAdyenOrderItem($paymentAdyenTransfer, $orderItem);
        }
    }

    /**
     * @param string $status
     * @param \Generated\Shared\Transfer\AdyenApiRequestTransfer $request
     * @param \Generated\Shared\Transfer\AdyenApiResponseTransfer $response
     *
     * @return void
     */
    public function updateOrderPaymentEntities(
        string $status,
        AdyenApiRequestTransfer $request,
        AdyenApiResponseTransfer $response
    ): void {
        $reference = $request->getMakePaymentRequest()->getReference();
        $pspReference = $response->getMakePaymentResponse()->getPspReference();

        $this->getTransactionHandler()->handleTransaction(function () use ($status, $reference, $pspReference) {
            $paymentAdyenTransfer = $this->repository->getPaymentAdyenByReference($reference);
            $paymentAdyenTransfer->setPspReference($pspReference);
            $this->entityManager->savePaymentAdyen($paymentAdyenTransfer);

            $paymentAdyenOrderItemTransfers = $this->repository
                ->getOrderItemsByReferenceAndIdOrderItem($reference);

            foreach ($paymentAdyenOrderItemTransfers as $paymentAdyenOrderItemTransfer) {
                $paymentAdyenOrderItemTransfer->setStatus($status);
                $this->entityManager->savePaymentAdyenOrderItem($paymentAdyenOrderItemTransfer);
            }
        });
    }

    /**
     * @param string $status
     * @param \Generated\Shared\Transfer\PaymentAdyenOrderItemTransfer[] $paymentAdyenOrderItemTransfers
     * @param \Generated\Shared\Transfer\PaymentAdyenTransfer $paymentAdyenTransfer
     *
     * @return void
     */
    public function update(
        string $status,
        array $paymentAdyenOrderItemTransfers,
        PaymentAdyenTransfer $paymentAdyenTransfer = null
    ): void {
        $this->getTransactionHandler()->handleTransaction(
            function () use ($status, $paymentAdyenOrderItemTransfers, $paymentAdyenTransfer) {
                if ($paymentAdyenTransfer !== null) {
                    $this->entityManager->savePaymentAdyen($paymentAdyenTransfer);
                }

                foreach ($paymentAdyenOrderItemTransfers as $paymentAdyenOrderItemTransfer) {
                    $paymentAdyenOrderItemTransfer->setStatus($status);
                    $this->entityManager->savePaymentAdyenOrderItem($paymentAdyenOrderItemTransfer);
                }
            }
        );
    }

    /**
     * @param string $type
     * @param \Generated\Shared\Transfer\AdyenApiRequestTransfer $request
     * @param \Generated\Shared\Transfer\AdyenApiResponseTransfer $response
     *
     * @return \Generated\Shared\Transfer\PaymentAdyenApiLogTransfer
     */
    public function savePaymentAdyenApiLog(
        string $type,
        AdyenApiRequestTransfer $request,
        AdyenApiResponseTransfer $response
    ): PaymentAdyenApiLogTransfer {
        $paymentAdyenApiLog = (new PaymentAdyenApiLogTransfer())
            ->setType($type)
            ->setRequest($request->serialize())
            ->setIsSuccess($response->getIsSuccess())
            ->setResponse($response->serialize());

        if (!$response->getIsSuccess()) {
            $paymentAdyenApiLog
                ->setStatusCode($response->getError()->getStatus())
                ->setErrorCode($response->getError()->getErrorCode())
                ->setErrorMessage($response->getError()->getMessage())
                ->setErrorType($response->getError()->getErrorType());
        }

        return $this->getTransactionHandler()->handleTransaction(function () use ($paymentAdyenApiLog) {
            return $this->entityManager->savePaymentAdyenApiLog($paymentAdyenApiLog);
        });
    }

    /**
     * @param \Generated\Shared\Transfer\PaymentTransfer $paymentTransfer
     * @param \Generated\Shared\Transfer\SaveOrderTransfer $saveOrderTransfer
     *
     * @return \Generated\Shared\Transfer\PaymentAdyenTransfer
     */
    protected function savePaymentAdyen(
        PaymentTransfer $paymentTransfer,
        SaveOrderTransfer $saveOrderTransfer
    ): PaymentAdyenTransfer {
        $paymentAdyenTransfer = (new PaymentAdyenTransfer())
            ->setFkSalesOrder($saveOrderTransfer->getIdSalesOrder())
            ->setOrderReference($saveOrderTransfer->getOrderReference())
            ->setPaymentMethod($paymentTransfer->getPaymentSelection())
            ->setReference($paymentTransfer->getAdyenPayment()->getReference());

        return $this->entityManager->savePaymentAdyen($paymentAdyenTransfer);
    }

    /**
     * @param \Generated\Shared\Transfer\PaymentAdyenTransfer $paymentAdyenTransfer
     * @param \Generated\Shared\Transfer\ItemTransfer $orderItem
     *
     * @return \Generated\Shared\Transfer\PaymentAdyenOrderItemTransfer
     */
    protected function savePaymentAdyenOrderItem(
        PaymentAdyenTransfer $paymentAdyenTransfer,
        ItemTransfer $orderItem
    ): PaymentAdyenOrderItemTransfer {
        $paymentAdyenOrderItemTransfer = (new PaymentAdyenOrderItemTransfer())
            ->setFkSalesOrderItem($orderItem->getIdSalesOrderItem())
            ->setFkPaymentAdyen($paymentAdyenTransfer->getIdPaymentAdyen())
            ->setStatus($this->config->getOmsStatusNew());

        return $this->entityManager->savePaymentAdyenOrderItem($paymentAdyenOrderItemTransfer);
    }
}
