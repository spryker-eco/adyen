<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Client\Adyen\Zed;

use Generated\Shared\Transfer\AdyenRedirectResponseTransfer;
use Spryker\Client\ZedRequest\Stub\ZedRequestStub;

class AdyenStub extends ZedRequestStub implements AdyenStubInterface
{
    /**
     * @param \Generated\Shared\Transfer\AdyenRedirectResponseTransfer $redirectResponseTransfer
     *
     * @return \Generated\Shared\Transfer\AdyenRedirectResponseTransfer
     */
    public function handleSofortResponseFromAdyen(AdyenRedirectResponseTransfer $redirectResponseTransfer): AdyenRedirectResponseTransfer
    {
        /** @var \Generated\Shared\Transfer\AdyenRedirectResponseTransfer $redirectResponseTransfer */
        $redirectResponseTransfer = $this->zedStub->call('/adyen/gateway/handle-sofort-response', $redirectResponseTransfer);

        return $redirectResponseTransfer;
    }
}
