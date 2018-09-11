<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Zed\Adyen\Business\Oms\Handler;

use Generated\Shared\Transfer\OrderTransfer;
use Spryker\Zed\Oms\Business\Util\ReadOnlyArrayObject;

interface AdyenCommandHandlerInterface
{
    /**
     * @param \Orm\Zed\Sales\Persistence\SpySalesOrderItem[] $orderItems
     * @param \Generated\Shared\Transfer\OrderTransfer $orderTransfer
     * @param \Spryker\Zed\Oms\Business\Util\ReadOnlyArrayObject $data
     *
     * @return void
     */
    public function handle(array $orderItems, OrderTransfer $orderTransfer, ReadOnlyArrayObject $data): void;
}
