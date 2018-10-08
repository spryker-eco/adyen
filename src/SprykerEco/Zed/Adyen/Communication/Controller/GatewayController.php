<?php

/**
 * MIT License
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerEco\Zed\Adyen\Communication\Controller;

use Generated\Shared\Transfer\AdyenNotificationsTransfer;
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

    /**
     * @param \Generated\Shared\Transfer\AdyenRedirectResponseTransfer $redirectResponseTransfer
     *
     * @return \Generated\Shared\Transfer\AdyenRedirectResponseTransfer
     */
    public function handleCreditCard3dResponseAction(AdyenRedirectResponseTransfer $redirectResponseTransfer): AdyenRedirectResponseTransfer
    {
        return $this->getFacade()->handleCreditCard3dResponseFromAdyen($redirectResponseTransfer);
    }

    /**
     * @param \Generated\Shared\Transfer\AdyenNotificationsTransfer $notificationsTransfer
     *
     * @return \Generated\Shared\Transfer\AdyenNotificationsTransfer
     */
    public function handleNotificationAction(AdyenNotificationsTransfer $notificationsTransfer): AdyenNotificationsTransfer
    {
        return $this->getFacade()->handleNotification($notificationsTransfer);
    }
}
