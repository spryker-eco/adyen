<?php

/**
 * MIT License
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerEco\Zed\Adyen\Business\Oms\Saver;

class CancelCommandSaver extends AbstractCommandSaver implements AdyenCommandSaverInterface
{
    /**
     * @var string
     */
    protected const REQUEST_TYPE = 'CANCEL';

    /**
     * @param array<\Orm\Zed\Sales\Persistence\SpySalesOrderItem> $orderItems
     *
     * @return void
     */
    public function save(array $orderItems): void
    {
        /** @var \Orm\Zed\Sales\Persistence\SpySalesOrderItem $orderItem */
        $orderItem = reset($orderItems);

        $this->writer->updatePaymentEntities(
            $this->config->getOmsStatusCancellationPending(),
            $this->reader->getAllPaymentAdyenOrderItemsByIdSalesOrder($orderItem->getFkSalesOrder()),
        );

        $this->triggerCancelEvent($orderItems);
    }

    /**
     * @return string
     */
    protected function getRequestType(): string
    {
        return static::REQUEST_TYPE;
    }

    /**
     * @param array<\Orm\Zed\Sales\Persistence\SpySalesOrderItem> $orderItems
     *
     * @return void
     */
    protected function triggerCancelEvent(array $orderItems): void
    {
        $remainingItems = $this->reader->getRemainingSalesOrderItemIds($orderItems);
        if (count($remainingItems) === 0) {
            return;
        }

        $this->omsFacade->triggerEventForOrderItems(
            $this->config->getOmsEventCancelName(),
            $remainingItems,
            [$this->config->getAdyenAutomaticOmsTrigger() => true],
        );
    }
}
