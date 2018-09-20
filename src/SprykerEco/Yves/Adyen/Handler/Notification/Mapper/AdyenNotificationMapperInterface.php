<?php

/**
 * MIT License
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerEco\Yves\Adyen\Handler\Notification\Mapper;

use Generated\Shared\Transfer\AdyenNotificationsTransfer;
use Symfony\Component\HttpFoundation\Request;

interface AdyenNotificationMapperInterface
{
    /**
     * @param \Symfony\Component\HttpFoundation\Request $request
     *
     * @return \Generated\Shared\Transfer\AdyenNotificationsTransfer
     */
    public function mapRequestToNotificationsTransfer(Request $request): AdyenNotificationsTransfer;
}
