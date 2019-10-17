<?php

/**
 * MIT License
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerEco\Yves\Adyen\Handler\Redirect;

use Generated\Shared\Transfer\AdyenRedirectResponseTransfer;

class KlarnaInvoiceRedirectHandler extends OnlineTransferRedirectHandler
{
    /**
     * @param \Generated\Shared\Transfer\AdyenRedirectResponseTransfer $redirectResponseTransfer
     *
     * @return \Generated\Shared\Transfer\AdyenRedirectResponseTransfer
     */
    protected function handleOnlineTransferResponse(AdyenRedirectResponseTransfer $redirectResponseTransfer): AdyenRedirectResponseTransfer
    {
        return $this->adyenClient->handleKlarnaInvoiceResponseFromAdyen($redirectResponseTransfer);
    }
}
