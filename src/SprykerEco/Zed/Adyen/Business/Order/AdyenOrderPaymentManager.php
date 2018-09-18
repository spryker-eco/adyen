<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Zed\Adyen\Business\Order;

use Generated\Shared\Transfer\QuoteTransfer;
use Generated\Shared\Transfer\SaveOrderTransfer;
use SprykerEco\Shared\Adyen\AdyenConfig;
use SprykerEco\Zed\Adyen\Business\Writer\AdyenWriterInterface;

class AdyenOrderPaymentManager implements AdyenOrderPaymentManagerInterface
{
    /**
     * @var \SprykerEco\Zed\Adyen\Business\Writer\AdyenWriterInterface
     */
    protected $writer;

    /**
     * @param \SprykerEco\Zed\Adyen\Business\Writer\AdyenWriterInterface $writer
     */
    public function __construct(AdyenWriterInterface $writer)
    {
        $this->writer = $writer;
    }

    /**
     * @param \Generated\Shared\Transfer\QuoteTransfer $quoteTransfer
     * @param \Generated\Shared\Transfer\SaveOrderTransfer $saveOrderTransfer
     *
     * @return void
     */
    public function saveOrderPayment(QuoteTransfer $quoteTransfer, SaveOrderTransfer $saveOrderTransfer): void
    {
        if ($quoteTransfer->getPayment()->getPaymentProvider() !== AdyenConfig::PROVIDER_NAME) {
            return;
        }

        $this->writer->savePaymentEntities($quoteTransfer->getPayment(), $saveOrderTransfer);
    }
}
