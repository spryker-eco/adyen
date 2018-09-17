<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Zed\Adyen\Business\Oms\Mapper;

use Generated\Shared\Transfer\AdyenApiAmountTransfer;
use Generated\Shared\Transfer\AdyenApiCancelOrRefundRequestTransfer;
use Generated\Shared\Transfer\AdyenApiRequestTransfer;
use Generated\Shared\Transfer\OrderTransfer;
use Orm\Zed\Sales\Persistence\SpySalesOrderItem;

class CancelOrRefundCommandMapper extends AbstractCommandMapper implements AdyenCommandMapperInterface
{
    /**
     * @param \Orm\Zed\Sales\Persistence\SpySalesOrderItem[] $orderItems
     * @param \Generated\Shared\Transfer\OrderTransfer $orderTransfer
     *
     * @return \Generated\Shared\Transfer\AdyenApiRequestTransfer
     */
    public function buildRequestTransfer(array $orderItems, OrderTransfer $orderTransfer): AdyenApiRequestTransfer
    {
        $request = new AdyenApiRequestTransfer();
        $paymentAdyen = $this->reader->getPaymentAdyenByOrderTransfer($orderTransfer);
        $request->setCancelOrRefundRequest(
            (new AdyenApiCancelOrRefundRequestTransfer())
                ->setMerchantAccount($this->config->getMerchantAccount())
                ->setOriginalReference($paymentAdyen->getPspReference())
                ->setOriginalMerchantReference($paymentAdyen->getReference())
                ->setModificationAmount($this->createAmountTransfer($orderItems, $orderTransfer))
        );

        return $request;
    }

    /**
     * @param \Orm\Zed\Sales\Persistence\SpySalesOrderItem[] $orderItems
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
     * @param \Orm\Zed\Sales\Persistence\SpySalesOrderItem[] $orderItems
     * @param \Generated\Shared\Transfer\OrderTransfer $orderTransfer
     *
     * @return int
     */
    protected function getAmountToModify(array $orderItems, OrderTransfer $orderTransfer): int
    {
        if (count($orderTransfer->getItems()) === count($orderItems)) {
            return $orderTransfer->getTotals()->getRefundTotal();
        }

        // TODO: Clarify this logic.
        $amount = array_map(
            function (SpySalesOrderItem $orderItem) {
                return $orderItem->getRefundableAmount();
            },
            $orderItems
        );

        return (int)array_sum($amount);
    }
}
