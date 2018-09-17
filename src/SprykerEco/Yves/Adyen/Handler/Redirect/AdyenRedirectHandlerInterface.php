<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Yves\Adyen\Handler\Redirect;

use Generated\Shared\Transfer\AdyenRedirectResponseTransfer;
use Symfony\Component\HttpFoundation\Request;

interface AdyenRedirectHandlerInterface
{
    /**
     * @param \Symfony\Component\HttpFoundation\Request $request
     *
     * @return \Generated\Shared\Transfer\AdyenRedirectResponseTransfer
     */
    public function handle(Request $request): AdyenRedirectResponseTransfer;
}
