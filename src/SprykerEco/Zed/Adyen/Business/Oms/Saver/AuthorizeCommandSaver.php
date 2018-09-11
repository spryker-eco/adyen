<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Zed\Adyen\Business\Oms\Saver;

class AuthorizeCommandSaver extends AbstractCommandSaver implements AdyenCommandSaverInterface
{
    protected const REQUEST_TYPE = 'AUTHORIZE';

    /**
     * @param \Orm\Zed\Sales\Persistence\SpySalesOrderItem[] $orderItems
     *
     * @return void
     */
    public function save(array $orderItems): void
    {
        $this->writer->update(
            $this->config->getOmsStatusAuthorized(),
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
