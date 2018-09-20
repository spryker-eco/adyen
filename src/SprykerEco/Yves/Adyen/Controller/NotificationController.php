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
    protected const HEADER_CONTENT_TYPE_KEY = 'Content-Type';
    protected const HEADER_CONTENT_TYPE_VALUE = 'application/json';
    protected const NOTIFICATION_ACCEPTED_RESPONSE = ['notificationResponse' => '[accepted]'];

    /**
     * @param \Symfony\Component\HttpFoundation\Request $request
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction(Request $request): Response
    {
        $response = $this->getFactory()->createNotificationHandler()->handle($request);
        if (!$response->getIsSuccess()) {
            return $this->createNotAcceptableResponse();
        }

        return $this->createAcceptedResponse();
    }

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     */
    protected function createAcceptedResponse(): Response
    {
        return new Response(
            $this->getFactory()->getUtilEncodingService()->encodeJson(static::NOTIFICATION_ACCEPTED_RESPONSE),
            Response::HTTP_ACCEPTED,
            [
                static::HEADER_CONTENT_TYPE_KEY => static::HEADER_CONTENT_TYPE_VALUE,
            ]
        );
    }

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     */
    protected function createNotAcceptableResponse(): Response
    {
        return new Response('', Response::HTTP_NOT_ACCEPTABLE);
    }
}
