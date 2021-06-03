<?php

/**
 * MIT License
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerEco\Yves\Adyen\Dependency\Client;

use Generated\Shared\Transfer\QuoteTransfer;

class AdyenToQuoteClientBridge implements AdyenToQuoteClientInterface
{
    /**
     * @var \Spryker\Client\Quote\QuoteClientInterface
     */
    protected $quoteClient;

    /**
     * @param \Spryker\Client\Quote\QuoteClientInterface $quoteClient
     */
    public function __construct($quoteClient)
    {
        $this->quoteClient = $quoteClient;
    }

    /**
     * @return \Generated\Shared\Transfer\QuoteTransfer
     */
    public function getQuote(): QuoteTransfer
    {
        return $this->quoteClient->getQuote();
    }

    /**
     * @param \Generated\Shared\Transfer\QuoteTransfer $quoteTransfer
     *
     * @return void
     */
    //phpcs:ignore
    public function setQuote(QuoteTransfer $quoteTransfer)
    {
        $this->quoteClient->setQuote($quoteTransfer);
    }
}
