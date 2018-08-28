<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Zed\Adyen\Business\Oms\Saver;

use Generated\Shared\Transfer\AdyenApiResponseTransfer;
use Generated\Shared\Transfer\OrderTransfer;
use Spryker\Zed\Kernel\Persistence\EntityManager\TransactionTrait;

class CaptureCommandSaver implements AdyenCommandSaverInterface
{
    use TransactionTrait;

    /**
     * @param \Generated\Shared\Transfer\AdyenApiResponseTransfer $responseTransfer
     * @param \Generated\Shared\Transfer\OrderTransfer $orderTransfer
     *
     * @return void
     */
    public function save(AdyenApiResponseTransfer $responseTransfer, OrderTransfer $orderTransfer): void
    {
        $this->getTransactionHandler()->handleTransaction(function () use ($responseTransfer, $orderTransfer) {
        });
    }
}
