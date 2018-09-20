<?php

/**
 * MIT License
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerEco\Yves\Adyen\Handler\Notification;

use Generated\Shared\Transfer\AdyenNotificationsTransfer;
use SprykerEco\Client\Adyen\AdyenClientInterface;
use SprykerEco\Yves\Adyen\Handler\Notification\Mapper\AdyenNotificationMapperInterface;
use Symfony\Component\HttpFoundation\Request;

class AdyenNotificationHandler implements AdyenNotificationHandlerInterface
{
    /**
     * @var \SprykerEco\Client\Adyen\AdyenClientInterface
     */
    protected $adyenClient;

    /**
     * @var \SprykerEco\Yves\Adyen\Handler\Notification\Mapper\AdyenNotificationMapperInterface
     */
    protected $mapper;

    /**
     * @param \SprykerEco\Client\Adyen\AdyenClientInterface $adyenClient
     * @param \SprykerEco\Yves\Adyen\Handler\Notification\Mapper\AdyenNotificationMapperInterface $mapper
     */
    public function __construct(
        AdyenClientInterface $adyenClient,
        AdyenNotificationMapperInterface $mapper
    ) {
        $this->adyenClient = $adyenClient;
        $this->mapper = $mapper;
    }

    /**
     * @param \Symfony\Component\HttpFoundation\Request $request
     *
     * @return \Generated\Shared\Transfer\AdyenNotificationsTransfer
     */
    public function handle(Request $request): AdyenNotificationsTransfer
    {
        $notificationsTransfer = $this->mapper->mapRequestToNotificationsTransfer($request);

        return $this->adyenClient->handleNotificationRequest($notificationsTransfer);
    }
}
