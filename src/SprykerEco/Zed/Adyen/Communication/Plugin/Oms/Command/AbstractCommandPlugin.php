<?php

/**
 * MIT License
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerEco\Zed\Adyen\Communication\Plugin\Oms\Command;

use Generated\Shared\Transfer\OrderTransfer;
use Orm\Zed\Sales\Persistence\SpySalesOrder;
use Spryker\Zed\Kernel\Communication\AbstractPlugin;

/**
 * @method \SprykerEco\Zed\Adyen\Business\AdyenFacadeInterface getFacade()
 * @method \SprykerEco\Zed\Adyen\AdyenConfig getConfig()
 * @method \SprykerEco\Zed\Adyen\Communication\AdyenCommunicationFactory getFactory()
 */
abstract class AbstractCommandPlugin extends AbstractPlugin
{
    /**
     * @param \Orm\Zed\Sales\Persistence\SpySalesOrder $orderEntity
     *
     * @return \Generated\Shared\Transfer\OrderTransfer
     */
    protected function getOrderTransfer(SpySalesOrder $orderEntity): OrderTransfer
    {
        $orderTransfer = $this
            ->getFactory()
            ->getSalesFacade()
            ->getOrderByIdSalesOrder($orderEntity->getIdSalesOrder());

        return $this
            ->getFactory()
            ->getCalculationFacade()
            ->recalculateOrder($orderTransfer);
    }
}
