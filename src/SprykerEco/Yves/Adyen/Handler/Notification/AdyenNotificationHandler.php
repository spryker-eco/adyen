<?php

/**
 * MIT License
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerEco\Yves\Adyen\Handler\Notification;

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
     * @return void
     */
    public function handle(Request $request): void
    {
        $notificationsTransfer = $this->mapper->mapRequestToNotificationsTransfer($request);
        $this->adyenClient->handleNotificationRequest($notificationsTransfer);
    }
}
