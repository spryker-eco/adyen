<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Yves\Adyen\Handler;

use Generated\Shared\Transfer\QuoteTransfer;
use SprykerEco\Yves\Adyen\AdyenConfig;

class AdyenPaymentHandler implements AdyenPaymentHandlerInterface
{
    /**
     * @var \SprykerEco\Yves\Adyen\AdyenConfig
     */
    protected $config;

    /**
     * @param \SprykerEco\Yves\Adyen\AdyenConfig $config
     */
    public function __construct(AdyenConfig $config)
    {
        $this->config = $config;
    }

    /**
     * @param \Generated\Shared\Transfer\QuoteTransfer $quoteTransfer
     *
     * @return \Generated\Shared\Transfer\QuoteTransfer
     */
    public function addPaymentToQuote(QuoteTransfer $quoteTransfer)
    {
        return $quoteTransfer;
    }
}
