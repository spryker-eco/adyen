<?php

/**
 * MIT License
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerEco\Client\Adyen\Zed;

use Generated\Shared\Transfer\AdyenNotificationsTransfer;
use Generated\Shared\Transfer\AdyenRedirectResponseTransfer;
use SprykerEco\Client\Adyen\Dependency\Client\AdyenToZedRequestClientInterface;

class AdyenStub implements AdyenStubInterface
{
    /**
     * @var \SprykerEco\Client\Adyen\Dependency\Client\AdyenToZedRequestClientInterface
     */
    protected $zedRequestClient;

    /**
     * @param \SprykerEco\Client\Adyen\Dependency\Client\AdyenToZedRequestClientInterface $zedRequestClient
     */
    public function __construct(AdyenToZedRequestClientInterface $zedRequestClient)
    {
        $this->zedRequestClient = $zedRequestClient;
    }

    /**
     * @param \Generated\Shared\Transfer\AdyenNotificationsTransfer $notificationsTransfer
     *
     * @return void
     */
    public function handleNotificationRequest(AdyenNotificationsTransfer $notificationsTransfer): void
    {
        $this->zedRequestClient->call('/adyen/gateway/handle-notification', $notificationsTransfer);
    }

    /**
     * @param \Generated\Shared\Transfer\AdyenRedirectResponseTransfer $redirectResponseTransfer
     *
     * @return \Generated\Shared\Transfer\AdyenRedirectResponseTransfer
     */
    public function handleOnlineTransferResponseFromAdyen(AdyenRedirectResponseTransfer $redirectResponseTransfer): AdyenRedirectResponseTransfer
    {
        /** @var \Generated\Shared\Transfer\AdyenRedirectResponseTransfer $redirectResponseTransfer */
        $redirectResponseTransfer = $this->zedRequestClient->call('/adyen/gateway/handle-online-transfer-response', $redirectResponseTransfer);

        return $redirectResponseTransfer;
    }

    /**
     * @param \Generated\Shared\Transfer\AdyenRedirectResponseTransfer $redirectResponseTransfer
     *
     * @return \Generated\Shared\Transfer\AdyenRedirectResponseTransfer
     */
    public function handleCreditCard3dResponseFromAdyen(AdyenRedirectResponseTransfer $redirectResponseTransfer): AdyenRedirectResponseTransfer
    {
        /** @var \Generated\Shared\Transfer\AdyenRedirectResponseTransfer $redirectResponseTransfer */
        $redirectResponseTransfer = $this->zedRequestClient->call('/adyen/gateway/handle-credit-card-3d-response', $redirectResponseTransfer);

        return $redirectResponseTransfer;
    }

    /**
     * @param \Generated\Shared\Transfer\AdyenRedirectResponseTransfer $redirectResponseTransfer
     *
     * @return \Generated\Shared\Transfer\AdyenRedirectResponseTransfer
     */
    public function handlePayPalResponseFromAdyen(AdyenRedirectResponseTransfer $redirectResponseTransfer): AdyenRedirectResponseTransfer
    {
        /** @var \Generated\Shared\Transfer\AdyenRedirectResponseTransfer $redirectResponseTransfer */
        $redirectResponseTransfer = $this->zedRequestClient->call('/adyen/gateway/handle-paypal-response', $redirectResponseTransfer);

        return $redirectResponseTransfer;
    }
}
