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
     * @return \Generated\Shared\Transfer\AdyenNotificationsTransfer
     */
    public function handleNotificationRequest(AdyenNotificationsTransfer $notificationsTransfer): AdyenNotificationsTransfer
    {
        /** @var \Generated\Shared\Transfer\AdyenNotificationsTransfer $notificationsTransfer */
        $notificationsTransfer = $this->zedRequestClient->call('/adyen/gateway/handle-notification', $notificationsTransfer);

        return $notificationsTransfer;
    }

    /**
     * @param \Generated\Shared\Transfer\AdyenRedirectResponseTransfer $redirectResponseTransfer
     *
     * @return \Generated\Shared\Transfer\AdyenRedirectResponseTransfer
     */
    public function handleSofortResponseFromAdyen(AdyenRedirectResponseTransfer $redirectResponseTransfer): AdyenRedirectResponseTransfer
    {
        /** @var \Generated\Shared\Transfer\AdyenRedirectResponseTransfer $redirectResponseTransfer */
        $redirectResponseTransfer = $this->zedRequestClient->call('/adyen/gateway/handle-sofort-response', $redirectResponseTransfer);

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
    public function handleIdealResponseFromAdyen(AdyenRedirectResponseTransfer $redirectResponseTransfer): AdyenRedirectResponseTransfer
    {
        /** @var \Generated\Shared\Transfer\AdyenRedirectResponseTransfer $redirectResponseTransfer */
        $redirectResponseTransfer = $this->zedRequestClient->call('/adyen/gateway/handle-ideal-response', $redirectResponseTransfer);

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

    /**
     * @param \Generated\Shared\Transfer\AdyenRedirectResponseTransfer $redirectResponseTransfer
     *
     * @return \Generated\Shared\Transfer\AdyenRedirectResponseTransfer
     */
    public function handleAliPayResponseFromAdyen(AdyenRedirectResponseTransfer $redirectResponseTransfer): AdyenRedirectResponseTransfer
    {
        /** @var \Generated\Shared\Transfer\AdyenRedirectResponseTransfer $redirectResponseTransfer */
        $redirectResponseTransfer = $this->zedRequestClient->call('/adyen/gateway/handle-alipay-response', $redirectResponseTransfer);

        return $redirectResponseTransfer;
    }
}
