<?php

/**
 * MIT License
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerEco\Yves\Adyen\Handler\Redirect;

use Generated\Shared\Transfer\AdyenRedirectResponseTransfer;
use SprykerEco\Shared\Adyen\AdyenApiRequestConfig;
use Symfony\Component\HttpFoundation\Request;

class CreditCard3dRedirectHandler extends OnlineTransferRedirectHandler
{
    /**
     * @param \Symfony\Component\HttpFoundation\Request $request
     *
     * @return \Generated\Shared\Transfer\AdyenRedirectResponseTransfer
     */
    protected function createAdyenRedirectResponseTransfer(Request $request): AdyenRedirectResponseTransfer
    {
        $quoteTransfer = $this->quoteClient->getQuote();
        $redirectResponseTransfer = (new AdyenRedirectResponseTransfer())
            ->setMd((string)$request->request->get(AdyenApiRequestConfig::MD_FIELD))
            ->setPaRes((string)$request->request->get(AdyenApiRequestConfig::PA_RES_FIELD))
            ->setReference($quoteTransfer->getPaymentOrFail()->getAdyenPaymentOrFail()->getReference());

        return $redirectResponseTransfer;
    }

    /**
     * @param \Generated\Shared\Transfer\AdyenRedirectResponseTransfer $redirectResponseTransfer
     *
     * @return \Generated\Shared\Transfer\AdyenRedirectResponseTransfer
     */
    protected function handleOnlineTransferResponse(AdyenRedirectResponseTransfer $redirectResponseTransfer): AdyenRedirectResponseTransfer
    {
        return $this->adyenClient->handleCreditCard3dResponseFromAdyen($redirectResponseTransfer);
    }
}
