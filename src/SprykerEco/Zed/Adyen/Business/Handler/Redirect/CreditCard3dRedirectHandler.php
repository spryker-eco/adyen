<?php

/**
 * MIT License
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerEco\Zed\Adyen\Business\Handler\Redirect;

use Generated\Shared\Transfer\AdyenRedirectResponseTransfer;
use SprykerEco\Shared\Adyen\AdyenSdkConfig;

class CreditCard3dRedirectHandler extends OnlineTransferRedirectHandler
{
    /**
     * @return string
     */
    protected function getOmsStatus(): string
    {
        return $this->config->getOmsStatusAuthorized();
    }

    /**
     * @param \Generated\Shared\Transfer\AdyenRedirectResponseTransfer $redirectResponseTransfer
     *
     * @return string[]
     */
    protected function getRequestDetails(AdyenRedirectResponseTransfer $redirectResponseTransfer): array
    {
        return [
            AdyenSdkConfig::MD_FIELD => $redirectResponseTransfer->getMd(),
            AdyenSdkConfig::PA_RES_FIELD => $redirectResponseTransfer->getPaRes(),
        ];
    }
}
