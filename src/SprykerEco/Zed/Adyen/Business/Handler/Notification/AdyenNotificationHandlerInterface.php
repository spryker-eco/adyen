<?php

/**
 * MIT License
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerEco\Zed\Adyen\Business\Handler\Notification;

use Generated\Shared\Transfer\AdyenNotificationsTransfer;

interface AdyenNotificationHandlerInterface
{
    /**
     * @param \Generated\Shared\Transfer\AdyenNotificationsTransfer $notificationsTransfer
     *
     * @return void
     */
    public function handle(AdyenNotificationsTransfer $notificationsTransfer): void;
}
