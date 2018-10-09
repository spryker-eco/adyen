<?php

/**
 * MIT License
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerEco\Yves\Adyen\Handler\Redirect;

use Generated\Shared\Transfer\AdyenRedirectResponseTransfer;
use SprykerEco\Client\Adyen\AdyenClientInterface;
use SprykerEco\Yves\Adyen\Dependency\Client\AdyenToQuoteClientInterface;
use Symfony\Component\HttpFoundation\Request;

class PayPalRedirectHandler implements AdyenRedirectHandlerInterface
{
    /**
     * @var \SprykerEco\Yves\Adyen\Dependency\Client\AdyenToQuoteClientInterface
     */
    protected $quoteClient;

    /**
     * @var \SprykerEco\Client\Adyen\AdyenClientInterface
     */
    protected $adyenClient;

    /**
     * @param \SprykerEco\Yves\Adyen\Dependency\Client\AdyenToQuoteClientInterface $quoteClient
     * @param \SprykerEco\Client\Adyen\AdyenClientInterface $adyenClient
     */
    public function __construct(
        AdyenToQuoteClientInterface $quoteClient,
        AdyenClientInterface $adyenClient
    ) {
        $this->quoteClient = $quoteClient;
        $this->adyenClient = $adyenClient;
    }

    /**
     * @param \Symfony\Component\HttpFoundation\Request $request
     *
     * @return \Generated\Shared\Transfer\AdyenRedirectResponseTransfer
     */
    public function handle(Request $request): AdyenRedirectResponseTransfer
    {
        $quoteTransfer = $this->quoteClient->getQuote();
        $responseTransfer = (new AdyenRedirectResponseTransfer())
            ->fromArray($request->query->all(), true);

        $responseTransfer->setReference($quoteTransfer->getPayment()->getAdyenPayment()->getReference());

        return $this->adyenClient->handlePayPalResponseFromAdyen($responseTransfer);
    }
}
