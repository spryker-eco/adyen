<?php

/**
 * MIT License
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerEco\Yves\Adyen\Controller;

use Spryker\Yves\Kernel\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * @method \SprykerEco\Yves\Adyen\AdyenFactory getFactory()
 */
class NotificationController extends AbstractController
{
    /**
     * @var array<string, string>
     */
    protected const NOTIFICATION_ACCEPTED_RESPONSE_HEADER = ['Content-Type' => 'application/json'];

    /**
     * @var array<string, string>
     */
    protected const NOTIFICATION_ACCEPTED_RESPONSE_BODY = ['notificationResponse' => '[accepted]'];

    /**
     * @param \Symfony\Component\HttpFoundation\Request $request
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction(Request $request): Response
    {
        $this->getFactory()->createNotificationHandler()->handle($request);

        return $this->createAcceptedResponse();
    }

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     */
    protected function createAcceptedResponse(): Response
    {
        return new Response(
            $this->getFactory()->getUtilEncodingService()->encodeJson(static::NOTIFICATION_ACCEPTED_RESPONSE_BODY),
            Response::HTTP_OK,
            static::NOTIFICATION_ACCEPTED_RESPONSE_HEADER,
        );
    }
}
