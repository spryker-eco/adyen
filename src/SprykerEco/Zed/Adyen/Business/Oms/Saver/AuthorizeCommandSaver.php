<?php

/**
 * MIT License
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerEco\Zed\Adyen\Business\Oms\Saver;

class AuthorizeCommandSaver extends AbstractCommandSaver implements AdyenCommandSaverInterface
{
    /**
     * @var string
     */
    protected const REQUEST_TYPE = 'AUTHORIZE';

    /**
     * @param \Orm\Zed\Sales\Persistence\SpySalesOrderItem[] $orderItems
     *
     * @return void
     */
    public function save(array $orderItems): void
    {
        $this->writer->updatePaymentEntities(
            $this->config->getOmsStatusAuthorized(),
            $this->reader->getPaymentAdyenOrderItemsByOrderItems($orderItems),
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
