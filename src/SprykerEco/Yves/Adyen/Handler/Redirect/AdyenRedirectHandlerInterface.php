<?php

/**
 * MIT License
 * For full license information, please view the LICENSE file that was distributed with this source code.
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
