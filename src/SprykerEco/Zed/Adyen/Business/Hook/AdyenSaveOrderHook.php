<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Zed\Adyen\Business\Hook;

use Generated\Shared\Transfer\CheckoutResponseTransfer;
use Generated\Shared\Transfer\QuoteTransfer;
use SprykerEco\Shared\Adyen\AdyenConfig as SharedAdyenConfig;

class AdyenSaveOrderHook implements AdyenHookInterface
{
    protected $config;

    protected $writer;

    public function __construct($writer, $config)
    {
        $this->writer = $writer;
        $this->config = $config;
    }

    /**
     * @param \Generated\Shared\Transfer\QuoteTransfer $quoteTransfer
     * @param \Generated\Shared\Transfer\CheckoutResponseTransfer $checkoutResponseTransfer
     *
     * @return void
     */
    public function execute(QuoteTransfer $quoteTransfer, CheckoutResponseTransfer $checkoutResponseTransfer): void
    {
        if ($quoteTransfer->getPayment()->getPaymentProvider() !== SharedAdyenConfig::PROVIDER_NAME) {
            return;
        }
    }
}
