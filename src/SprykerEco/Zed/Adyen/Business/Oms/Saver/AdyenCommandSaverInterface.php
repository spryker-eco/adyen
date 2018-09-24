<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Zed\Adyen\Business\Oms\Saver;

use Generated\Shared\Transfer\AdyenApiRequestTransfer;
use Generated\Shared\Transfer\AdyenApiResponseTransfer;

interface AdyenCommandSaverInterface
{
    /**
     * @param \Orm\Zed\Sales\Persistence\SpySalesOrderItem[] $orderItems
     *
     * @return void
     */
    public function save(array $orderItems): void;

    /**
     * @param \Generated\Shared\Transfer\AdyenApiRequestTransfer $requestTransfer
     * @param \Generated\Shared\Transfer\AdyenApiResponseTransfer $responseTransfer
     *
     * @return void
     */
    public function logResponse(
        AdyenApiRequestTransfer $requestTransfer,
        AdyenApiResponseTransfer $responseTransfer
    ): void;
}
