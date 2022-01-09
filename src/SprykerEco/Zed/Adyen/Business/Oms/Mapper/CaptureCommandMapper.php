<?php

/**
 * MIT License
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerEco\Zed\Adyen\Business\Oms\Mapper;

use Generated\Shared\Transfer\AdyenApiAmountTransfer;
use Generated\Shared\Transfer\AdyenApiCaptureRequestTransfer;
use Generated\Shared\Transfer\AdyenApiRequestTransfer;
use Generated\Shared\Transfer\OrderTransfer;
use Orm\Zed\Sales\Persistence\SpySalesOrderItem;

class CaptureCommandMapper extends AbstractCommandMapper implements AdyenCommandMapperInterface
{
    /**
     * @var int
     */
    protected const AMOUNT_TO_MODIFY_DEFAULT = 0;

    /**
     * @param array<\Orm\Zed\Sales\Persistence\SpySalesOrderItem> $orderItems
     * @param \Generated\Shared\Transfer\OrderTransfer $orderTransfer
     *
     * @return \Generated\Shared\Transfer\AdyenApiRequestTransfer
     */
    public function buildRequestTransfer(array $orderItems, OrderTransfer $orderTransfer): AdyenApiRequestTransfer
    {
        $request = new AdyenApiRequestTransfer();
        $paymentAdyen = $this->reader->getPaymentAdyenByOrderTransfer($orderTransfer);
        $request->setCaptureRequest(
            (new AdyenApiCaptureRequestTransfer())
                ->setMerchantAccount($this->config->getMerchantAccount())
                ->setOriginalReference($paymentAdyen->getPspReference())
                ->setOriginalMerchantReference($paymentAdyen->getReference())
                ->setModificationAmount($this->createAmountTransfer($orderItems, $orderTransfer)),
        );

        return $request;
    }

    /**
     * @param array<\Orm\Zed\Sales\Persistence\SpySalesOrderItem> $orderItems
     * @param \Generated\Shared\Transfer\OrderTransfer $orderTransfer
     *
     * @return \Generated\Shared\Transfer\AdyenApiAmountTransfer
     */
    protected function createAmountTransfer(array $orderItems, OrderTransfer $orderTransfer): AdyenApiAmountTransfer
    {
        return (new AdyenApiAmountTransfer())
            ->setValue($this->getAmountToModify($orderItems, $orderTransfer))
            ->setCurrency($orderTransfer->getCurrencyIsoCode());
    }

    /**
     * @param array<\Orm\Zed\Sales\Persistence\SpySalesOrderItem> $orderItems
     * @param \Generated\Shared\Transfer\OrderTransfer $orderTransfer
     *
     * @return int
     */
    protected function getAmountToModify(array $orderItems, OrderTransfer $orderTransfer): int
    {
        if ($orderTransfer->getItems()->count() === count($orderItems)) {
            return $orderTransfer->getTotalsOrFail()->getGrandTotal() ?? static::AMOUNT_TO_MODIFY_DEFAULT;
        }

        $amount = array_map(
            function (SpySalesOrderItem $orderItem) {
                return $orderItem->getPriceToPayAggregation() ?? static::AMOUNT_TO_MODIFY_DEFAULT;
            },
            $orderItems,
        );

        return (int)array_sum($amount);
    }
}
