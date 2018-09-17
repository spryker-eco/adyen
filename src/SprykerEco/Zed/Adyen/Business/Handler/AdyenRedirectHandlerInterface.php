<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Zed\Adyen\Business\Handler;

use Generated\Shared\Transfer\AdyenRedirectResponseTransfer;

interface AdyenRedirectHandlerInterface
{
    /**
     * @param \Generated\Shared\Transfer\AdyenRedirectResponseTransfer $redirectResponseTransfer
     *
     * @return \Generated\Shared\Transfer\AdyenRedirectResponseTransfer
     */
    public function handle(AdyenRedirectResponseTransfer $redirectResponseTransfer): AdyenRedirectResponseTransfer;
}
