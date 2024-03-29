<?php

/**
 * MIT License
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerEco\Zed\Adyen\Business\Handler\Redirect;

use Generated\Shared\Transfer\AdyenRedirectResponseTransfer;
use SprykerEco\Shared\Adyen\AdyenApiRequestConfig;

class CreditCard3dRedirectHandler extends OnlineTransferRedirectHandler
{
    /**
     * @param \Generated\Shared\Transfer\AdyenRedirectResponseTransfer $redirectResponseTransfer
     *
     * @return array<string, string|null>
     */
    protected function getRequestDetails(AdyenRedirectResponseTransfer $redirectResponseTransfer): array
    {
        return [
            AdyenApiRequestConfig::MD_FIELD => $redirectResponseTransfer->getMd(),
            AdyenApiRequestConfig::PA_RES_FIELD => $redirectResponseTransfer->getPaRes(),
        ];
    }
}
