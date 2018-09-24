<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Zed\Adyen\Business\Oms\Saver;

class CaptureCommandSaver extends AbstractCommandSaver implements AdyenCommandSaverInterface
{
    protected const REQUEST_TYPE = 'CAPTURE';

    /**
     * @param \Orm\Zed\Sales\Persistence\SpySalesOrderItem[] $orderItems
     *
     * @return void
     */
    public function save(array $orderItems): void
    {
        $this->writer->updatePaymentEntities(
            $this->config->getOmsStatusCaptured(),
            $this->reader->getPaymentAdyenOrderItemsByOrderItems($orderItems)
        );

        $remainingItems = $this->reader->getRemainingPaymentAdyenOrderItems($orderItems);

        if (count($remainingItems) === 0) {
            return;
        }

        if (!$this->config->isMultiplePartialCaptureEnabled()) {
            $this->writer->updatePaymentEntities(
                $this->config->getOmsStatusCanceled(),
                $remainingItems
            );

            $this->triggerCancelEvent($orderItems);
        }
    }

    /**
     * @return string
     */
    protected function getRequestType(): string
    {
        return static::REQUEST_TYPE;
    }

    /**
     * @param \Orm\Zed\Sales\Persistence\SpySalesOrderItem[] $orderItems
     *
     * @return void
     */
    protected function triggerCancelEvent(array $orderItems): void
    {
        $this->omsFacade->triggerEventForOrderItems(
            $this->config->getOmsEventCancelName(),
            $this->reader->getRemainingSalesOrderItemIds($orderItems),
            [$this->config->getAdyenAutomaticOmsTrigger() => true]
        );
    }
}
