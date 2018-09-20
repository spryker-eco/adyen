<?php

/**
 * MIT License
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerEco\Client\Adyen\Zed;

use Generated\Shared\Transfer\AdyenNotificationsTransfer;
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

    /**
     * @param \Generated\Shared\Transfer\AdyenNotificationsTransfer $notificationsTransfer
     *
     * @return \Generated\Shared\Transfer\AdyenNotificationsTransfer
     */
    public function handleNotificationRequest(AdyenNotificationsTransfer $notificationsTransfer): AdyenNotificationsTransfer
    {
        /** @var \Generated\Shared\Transfer\AdyenNotificationsTransfer $notificationsTransfer */
        $notificationsTransfer = $this->zedStub->call('/adyen/gateway/handle-notification', $notificationsTransfer);

        return $notificationsTransfer;
    }
}
