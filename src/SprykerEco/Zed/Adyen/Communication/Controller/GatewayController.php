<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Zed\Adyen\Communication\Controller;

use Generated\Shared\Transfer\AdyenRedirectResponseTransfer;
use Spryker\Zed\Kernel\Communication\Controller\AbstractGatewayController;

/**
 * @method \SprykerEco\Zed\Adyen\Business\AdyenFacadeInterface getFacade()
 */
class GatewayController extends AbstractGatewayController
{
    /**
     * @param \Generated\Shared\Transfer\AdyenRedirectResponseTransfer $redirectResponseTransfer
     *
     * @return \Generated\Shared\Transfer\AdyenRedirectResponseTransfer
     */
    public function handleSofortResponseAction(AdyenRedirectResponseTransfer $redirectResponseTransfer): AdyenRedirectResponseTransfer
    {
        return $this->getFacade()->handleSofortResponseFromAdyen($redirectResponseTransfer);
    }
}
