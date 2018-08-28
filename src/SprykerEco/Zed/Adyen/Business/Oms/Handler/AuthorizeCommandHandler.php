<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Zed\Adyen\Business\Oms\Handler;

use Generated\Shared\Transfer\AdyenApiRequestTransfer;
use Generated\Shared\Transfer\AdyenApiResponseTransfer;

class AuthorizeCommandHandler extends AbstractCommandHandler implements AdyenCommandHandlerInterface
{
    protected const REQUEST_TYPE = 'AUTHORIZE';

    /**
     * @param \Generated\Shared\Transfer\AdyenApiRequestTransfer $request
     *
     * @return \Generated\Shared\Transfer\AdyenApiResponseTransfer
     */
    protected function sendApiRequest(AdyenApiRequestTransfer $request): AdyenApiResponseTransfer
    {
        return $this->adyenApiFacade->performAuthorizeApiCall($request);
    }

    /**
     * @return string
     */
    protected function getRequestType(): string
    {
        return static::REQUEST_TYPE;
    }
}
