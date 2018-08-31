<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Zed\Adyen\Business\Hook;

use Generated\Shared\Transfer\CheckoutResponseTransfer;
use Generated\Shared\Transfer\QuoteTransfer;

class AdyenPostCheckHook implements AdyenHookInterface
{
    protected $config;

    protected $adyenApiFacade;

    public function __construct()
    {
    }

    /**
     * @param \Generated\Shared\Transfer\QuoteTransfer $quoteTransfer
     * @param \Generated\Shared\Transfer\CheckoutResponseTransfer $checkoutResponseTransfer
     *
     * @return void
     */
    public function execute(QuoteTransfer $quoteTransfer, CheckoutResponseTransfer $checkoutResponseTransfer): void
    {
    }
}
