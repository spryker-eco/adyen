<?php

/**
 * MIT License
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerEco\Zed\Adyen\Business\Handler\Redirect;

use Generated\Shared\Transfer\AdyenRedirectResponseTransfer;
use SprykerEco\Shared\Adyen\AdyenApiRequestConfig;

class KlarnaInvoiceRedirectHandler extends OnlineTransferRedirectHandler
{
    /**
     * @param \Generated\Shared\Transfer\AdyenRedirectResponseTransfer $redirectResponseTransfer
     *
     * @return string[]
     */
    protected function getRequestDetails(AdyenRedirectResponseTransfer $redirectResponseTransfer): array
    {
        return [
            AdyenApiRequestConfig::REDIRECT_RESULT_FIELD => $redirectResponseTransfer->getRedirectResult(),
        ];
    }
}
