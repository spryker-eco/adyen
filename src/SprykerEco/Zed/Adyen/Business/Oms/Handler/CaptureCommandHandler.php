<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Zed\Adyen\Business\Oms\Handler;

use Generated\Shared\Transfer\AdyenApiRequestTransfer;
use Generated\Shared\Transfer\AdyenApiResponseTransfer;

class CaptureCommandHandler extends AbstractCommandHandler implements AdyenCommandHandlerInterface
{
    /**
     * @param \Generated\Shared\Transfer\AdyenApiRequestTransfer $request
     *
     * @return \Generated\Shared\Transfer\AdyenApiResponseTransfer
     */
    protected function sendApiRequest(AdyenApiRequestTransfer $request): AdyenApiResponseTransfer
    {
        return $this->adyenApiFacade->performCaptureApiCall($request);
    }
}
