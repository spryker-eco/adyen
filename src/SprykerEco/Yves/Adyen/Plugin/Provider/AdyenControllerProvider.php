<?php

/**
 * MIT License
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerEco\Yves\Adyen\Plugin\Provider;

use Silex\Application;
use Spryker\Yves\Application\Plugin\Provider\YvesControllerProvider;

class AdyenControllerProvider extends YvesControllerProvider
{
    protected const BUNDLE_NAME = 'Adyen';
    protected const CALLBACK_CONTROLLER_NAME = 'Callback';
    protected const NOTIFICATION_CONTROLLER_NAME = 'Notification';

    /**
     * @param \Silex\Application $app
     *
     * @return void
     */
    protected function defineControllers(Application $app)
    {
        $this->createController(
            '/adyen/notification',
            'adyen-notification',
            static::BUNDLE_NAME,
            static::NOTIFICATION_CONTROLLER_NAME,
            'index'
        );

        $this->createController(
            '/adyen/callback/redirect-sofort',
            'adyen-redirect-sofort',
            static::BUNDLE_NAME,
            static::CALLBACK_CONTROLLER_NAME,
            'redirectSofort'
        );

        $this->createController(
            '/adyen/callback/redirect-credit-card-3d',
            'adyen-redirect-credit-card-3d',
            static::BUNDLE_NAME,
            static::CALLBACK_CONTROLLER_NAME,
            'redirectCreditCard3d'
        );

        $this->createController(
            '/adyen/callback/redirect-ideal',
            'adyen-redirect-ideal',
            static::BUNDLE_NAME,
            static::CALLBACK_CONTROLLER_NAME,
            'redirectIdeal'
        );

        $this->createController(
            '/adyen/callback/redirect-paypal',
            'adyen-redirect-paypal',
            static::BUNDLE_NAME,
            static::CALLBACK_CONTROLLER_NAME,
            'redirectPayPal'
        );
    }
}