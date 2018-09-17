<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Client\Adyen\Zed;

use Generated\Shared\Transfer\AdyenRedirectResponseTransfer;

interface AdyenStubInterface
{
    /**
     * @param \Generated\Shared\Transfer\AdyenRedirectResponseTransfer $redirectResponseTransfer
     *
     * @return \Generated\Shared\Transfer\AdyenRedirectResponseTransfer
     */
    public function handleSofortResponseFromAdyen(AdyenRedirectResponseTransfer $redirectResponseTransfer): AdyenRedirectResponseTransfer;
}
