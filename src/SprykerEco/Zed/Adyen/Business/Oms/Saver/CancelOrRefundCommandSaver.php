<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Zed\Adyen\Business\Oms\Saver;

class CancelOrRefundCommandSaver extends AbstractCommandSaver implements AdyenCommandSaverInterface
{
    protected const REQUEST_TYPE = 'CANCEL OR REFUND';

    /**
     * @param \Orm\Zed\Sales\Persistence\SpySalesOrderItem[] $orderItems
     *
     * @return void
     */
    public function save(array $orderItems): void
    {
        $this->writer->update(
            $this->config->getOmsStatusRefunded(),
            $this->reader->getPaymentAdyenOrderItemsByOrderItems($orderItems)
        );
    }

    /**
     * @return string
     */
    protected function getRequestType(): string
    {
        return static::REQUEST_TYPE;
    }
}
