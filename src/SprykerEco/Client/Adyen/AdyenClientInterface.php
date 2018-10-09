<?php

/**
 * MIT License
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerEco\Client\Adyen;

use Generated\Shared\Transfer\AdyenNotificationsTransfer;
use Generated\Shared\Transfer\AdyenRedirectResponseTransfer;

interface AdyenClientInterface
{
    /**
     * Specification:
     * - Handle notification from API.
     * - Update payment entities.
     * - Update order items statuses.
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\AdyenNotificationsTransfer $notificationsTransfer
     *
     * @return \Generated\Shared\Transfer\AdyenNotificationsTransfer
     */
    public function handleNotificationRequest(AdyenNotificationsTransfer $notificationsTransfer): AdyenNotificationsTransfer;

    /**
     * Specification:
     * - Handle response from Adyen after redirect customer back to the shop.
     * - Save response, update status etc.
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\AdyenRedirectResponseTransfer $redirectResponseTransfer
     *
     * @return \Generated\Shared\Transfer\AdyenRedirectResponseTransfer
     */
    public function handleSofortResponseFromAdyen(AdyenRedirectResponseTransfer $redirectResponseTransfer): AdyenRedirectResponseTransfer;

    /**
     * Specification:
     * - Handle response from Adyen after redirect customer back to the shop.
     * - Save response, update status etc.
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\AdyenRedirectResponseTransfer $redirectResponseTransfer
     *
     * @return \Generated\Shared\Transfer\AdyenRedirectResponseTransfer
     */
    public function handleCreditCard3dResponseFromAdyen(AdyenRedirectResponseTransfer $redirectResponseTransfer): AdyenRedirectResponseTransfer;

    /**
     * Specification:
     * - Handle response from Adyen after redirect customer back to the shop.
     * - Save response, update status etc.
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\AdyenRedirectResponseTransfer $redirectResponseTransfer
     *
     * @return \Generated\Shared\Transfer\AdyenRedirectResponseTransfer
     */
    public function handleIdealResponseFromAdyen(AdyenRedirectResponseTransfer $redirectResponseTransfer): AdyenRedirectResponseTransfer;

    /**
     * Specification:
     * - Handle response from Adyen after redirect customer back to the shop.
     * - Save response, update status etc.
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\AdyenRedirectResponseTransfer $redirectResponseTransfer
     *
     * @return \Generated\Shared\Transfer\AdyenRedirectResponseTransfer
     */
    public function handlePayPalResponseFromAdyen(AdyenRedirectResponseTransfer $redirectResponseTransfer): AdyenRedirectResponseTransfer;
}
