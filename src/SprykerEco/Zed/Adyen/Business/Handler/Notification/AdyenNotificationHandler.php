<?php

/**
 * MIT License
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerEco\Zed\Adyen\Business\Handler\Notification;

use Generated\Shared\Transfer\AdyenNotificationRequestItemTransfer;
use Generated\Shared\Transfer\AdyenNotificationsTransfer;
use SprykerEco\Zed\Adyen\AdyenConfig;
use SprykerEco\Zed\Adyen\Business\Reader\AdyenReaderInterface;
use SprykerEco\Zed\Adyen\Business\Writer\AdyenWriterInterface;
use SprykerEco\Zed\Adyen\Dependency\Service\AdyenToUtilEncodingServiceInterface;

class AdyenNotificationHandler implements AdyenNotificationHandlerInterface
{
    /**
     * @var \SprykerEco\Zed\Adyen\Dependency\Service\AdyenToUtilEncodingServiceInterface
     */
    protected $utilEncodingService;

    /**
     * @var \SprykerEco\Zed\Adyen\Business\Reader\AdyenReaderInterface
     */
    protected $reader;

    /**
     * @var \SprykerEco\Zed\Adyen\Business\Writer\AdyenWriterInterface
     */
    protected $writer;

    /**
     * @var \SprykerEco\Zed\Adyen\AdyenConfig
     */
    protected $config;

    /**
     * @param \SprykerEco\Zed\Adyen\Dependency\Service\AdyenToUtilEncodingServiceInterface $utilEncodingService
     * @param \SprykerEco\Zed\Adyen\Business\Reader\AdyenReaderInterface $reader
     * @param \SprykerEco\Zed\Adyen\Business\Writer\AdyenWriterInterface $writer
     * @param \SprykerEco\Zed\Adyen\AdyenConfig $config
     */
    public function __construct(
        AdyenToUtilEncodingServiceInterface $utilEncodingService,
        AdyenReaderInterface $reader,
        AdyenWriterInterface $writer,
        AdyenConfig $config
    ) {
        $this->utilEncodingService = $utilEncodingService;
        $this->reader = $reader;
        $this->writer = $writer;
        $this->config = $config;
    }

    /**
     * @param \Generated\Shared\Transfer\AdyenNotificationsTransfer $notificationsTransfer
     *
     * @return void
     */
    public function handle(AdyenNotificationsTransfer $notificationsTransfer): void
    {
        foreach ($notificationsTransfer->getNotificationItems() as $notificationItem) {
            $this->handleNotification($notificationItem);
        }
    }

    /**
     * @param \Generated\Shared\Transfer\AdyenNotificationRequestItemTransfer $notificationTransfer
     *
     * @return void
     */
    protected function handleNotification(AdyenNotificationRequestItemTransfer $notificationTransfer): void
    {
        if (!$notificationTransfer->getSuccess()) {
            return;
        }

        $statuses = $this->config->getMappedOmsStatuses();
        if (!array_key_exists($notificationTransfer->getEventCode(), $statuses)) {
            return;
        }

        $paymentAdyenTransfer = $this->reader->getPaymentAdyenByPspReference($notificationTransfer->getPspReference());
        if (!$paymentAdyenTransfer->getFkSalesOrder()) {
            return;
        }

        $paymentAdyenOrderItems = $this->reader
            ->getAllPaymentAdyenOrderItemsByIdSalesOrder($paymentAdyenTransfer->getFkSalesOrder());
        $paymentAdyenTransfer->setAdditionalData(
            $this->utilEncodingService->encodeJson($notificationTransfer->getAdditionalData())
        );

        $this->writer->updatePaymentEntities(
            $statuses[$notificationTransfer->getEventCode()],
            $paymentAdyenOrderItems,
            $paymentAdyenTransfer
        );
    }
}
