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
     * - Handles notification from API.
     * - Updates payment entities.
     * - Updates order items statuses.
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
     * - Handles redirect response from the Adyen after authorization on Sofort, iDeal, AliPay, WeChatPay payment methods has been passed.
     * - Saves the Adyen response.
     * - Updates the Adyen payment data (status and data).
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\AdyenRedirectResponseTransfer $redirectResponseTransfer
     *
     * @return \Generated\Shared\Transfer\AdyenRedirectResponseTransfer
     */
    public function handleOnlineTransferResponseFromAdyen(AdyenRedirectResponseTransfer $redirectResponseTransfer): AdyenRedirectResponseTransfer;

    /**
     * Specification:
     * - Handles redirect response from the Adyen after 3D secure has been passed.
     * - Saves the Adyen response.
     * - Updates the Adyen payment data (status and data).
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
     * - Handles redirect response from the Adyen after Klarna Invoice has been passed.
     * - Saves the Adyen response.
     * - Updates the Adyen payment data (status and data).
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\AdyenRedirectResponseTransfer $redirectResponseTransfer
     *
     * @return \Generated\Shared\Transfer\AdyenRedirectResponseTransfer
     */
    public function handleKlarnaInvoiceResponseFromAdyen(AdyenRedirectResponseTransfer $redirectResponseTransfer): AdyenRedirectResponseTransfer;
}
