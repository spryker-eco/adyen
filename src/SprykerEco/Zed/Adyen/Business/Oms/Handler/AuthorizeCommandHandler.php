<?php

/**
 * MIT License
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerEco\Zed\Adyen\Business\Oms\Handler;

use Generated\Shared\Transfer\AdyenApiRequestTransfer;
use Generated\Shared\Transfer\AdyenApiResponseTransfer;

class AuthorizeCommandHandler extends AbstractCommandHandler implements AdyenCommandHandlerInterface
{
    /**
     * @param \Generated\Shared\Transfer\AdyenApiRequestTransfer $request
     *
     * @return \Generated\Shared\Transfer\AdyenApiResponseTransfer
     */
    protected function sendApiRequest(AdyenApiRequestTransfer $request): AdyenApiResponseTransfer
    {
        return $this->adyenApiFacade->performAuthorizeApiCall($request);
    }
}
