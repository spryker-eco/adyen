<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Zed\Adyen\Business\Oms\Saver;

use Generated\Shared\Transfer\AdyenApiRequestTransfer;
use Generated\Shared\Transfer\AdyenApiResponseTransfer;

class CaptureCommandSaver extends AbstractCommandSaver implements AdyenCommandSaverInterface
{
    const REQUEST_TYPE_CAPTURE = 'CAPTURE';

    /**
     * @param \Orm\Zed\Sales\Persistence\SpySalesOrderItem[] $orderItems
     * @param \Generated\Shared\Transfer\AdyenApiRequestTransfer $requestTransfer
     * @param \Generated\Shared\Transfer\AdyenApiResponseTransfer $responseTransfer
     *
     * @return void
     */
    public function save(
        array $orderItems,
        AdyenApiRequestTransfer $requestTransfer,
        AdyenApiResponseTransfer $responseTransfer
    ): void {
        $this->writer->update(
            $this->config->getOmsStatusCaptured(),
            $this->reader->getPaymentAdyenOrderItemsByOrderItems($orderItems)
        );

        $this->writer->savePaymentAdyenApiLog(
            static::REQUEST_TYPE_CAPTURE,
            $requestTransfer,
            $responseTransfer
        );
    }
}
