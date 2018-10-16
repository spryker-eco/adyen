<?php

/**
 * MIT License
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerEco\Zed\Adyen\Business\Handler\Redirect;

class PayPalRedirectHandler extends OnlineTransferRedirectHandler
{
    /**
     * @return string
     */
    protected function getOmsStatus(): string
    {
        return $this->config->getOmsStatusAuthorized();
    }
}
