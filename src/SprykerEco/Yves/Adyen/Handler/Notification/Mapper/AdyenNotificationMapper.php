<?php

/**
 * MIT License
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerEco\Yves\Adyen\Handler\Notification\Mapper;

use ArrayObject;
use Generated\Shared\Transfer\AdyenNotificationRequestItemTransfer;
use Generated\Shared\Transfer\AdyenNotificationsTransfer;
use SprykerEco\Yves\Adyen\Dependency\Service\AdyenToUtilEncodingServiceInterface;
use Symfony\Component\HttpFoundation\Request;

class AdyenNotificationMapper implements AdyenNotificationMapperInterface
{
    /**
     * @var string
     */
    protected const NOTIFICATIONS_KEY = 'notificationItems';

    /**
     * @var string
     */
    protected const NOTIFICATION_ITEM_KEY = 'NotificationRequestItem';

    /**
     * @var string
     */
    protected const LIVE_KEY = 'live';

    /**
     * @var \SprykerEco\Yves\Adyen\Dependency\Service\AdyenToUtilEncodingServiceInterface
     */
    protected $utilEncodingService;

    /**
     * @param \SprykerEco\Yves\Adyen\Dependency\Service\AdyenToUtilEncodingServiceInterface $utilEncodingService
     */
    public function __construct(AdyenToUtilEncodingServiceInterface $utilEncodingService)
    {
        $this->utilEncodingService = $utilEncodingService;
    }

    /**
     * @param \Symfony\Component\HttpFoundation\Request $request
     *
     * @return \Generated\Shared\Transfer\AdyenNotificationsTransfer
     */
    public function mapRequestToNotificationsTransfer(Request $request): AdyenNotificationsTransfer
    {
        $response = $this->utilEncodingService->decodeJson((string)$request->getContent(), true);
        $notificationsTransfer = $this->createNotificationsTransfer($response);
        $notificationsTransfer->setNotificationItems(new ArrayObject($this->getNotificationItemTransfers($response)));

        return $notificationsTransfer;
    }

    /**
     * @param array<string> $response
     *
     * @return \Generated\Shared\Transfer\AdyenNotificationsTransfer
     */
    protected function createNotificationsTransfer(array $response): AdyenNotificationsTransfer
    {
        return (new AdyenNotificationsTransfer())
            ->setLive(filter_var($response[static::LIVE_KEY], FILTER_VALIDATE_BOOLEAN));
    }

    /**
     * @param array<string, mixed> $response
     *
     * @return array<\Generated\Shared\Transfer\AdyenNotificationRequestItemTransfer>
     */
    protected function getNotificationItemTransfers(array $response): array
    {
        $notificationItems = array_map(
            function ($notification) {
                $item = $notification[static::NOTIFICATION_ITEM_KEY];

                return (new AdyenNotificationRequestItemTransfer())->fromArray($item, true);
            },
            $response[static::NOTIFICATIONS_KEY],
        );

        return $notificationItems;
    }
}
