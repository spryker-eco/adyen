<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Zed\Adyen\Business\Oms\Mapper;

use Generated\Shared\Transfer\AdyenApiAmountTransfer;
use Generated\Shared\Transfer\OrderTransfer;
use Orm\Zed\Sales\Persistence\SpySalesOrderItem;
use SprykerEco\Zed\Adyen\AdyenConfig;
use SprykerEco\Zed\Adyen\Business\Reader\AdyenReaderInterface;

class AbstractCommandMapper
{
    protected $reader;
    protected $config;

    public function __construct(
        AdyenReaderInterface $reader,
        AdyenConfig $config
    ) {
        $this->reader = $reader;
        $this->config = $config;
    }

    protected function createAmountTransfer(array $orderItems, OrderTransfer $orderTransfer)
    {
        return (new AdyenApiAmountTransfer())
            ->setValue($this->getAmountToModify($orderItems))
            ->setCurrency($orderTransfer->getCurrencyIsoCode());
    }

    protected function getAmountToModify(array $orderItems)
    {
        $amount = array_map(
            function (SpySalesOrderItem $orderItem) {
                return $orderItem->getPriceToPayAggregation();
            },
            $orderItems
        );

        return array_sum($amount);
    }
}
