<?php

/**
 * MIT License
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerEco\Yves\Adyen\Plugin\Provider;

use Silex\Application;
use SprykerShop\Yves\ShopApplication\Plugin\Provider\AbstractYvesControllerProvider;

/**
 * @deprecated Use {@link \SprykerEco\Yves\Adyen\Plugin\Router\AdyenRouteProviderPlugin} instead.
 */
class AdyenControllerProvider extends AbstractYvesControllerProvider
{
    /**
     * @var string
     */
    protected const BUNDLE_NAME = 'Adyen';

    /**
     * @var string
     */
    protected const CALLBACK_CONTROLLER_NAME = 'Callback';

    /**
     * @var string
     */
    protected const NOTIFICATION_CONTROLLER_NAME = 'Notification';

    /**
     * @param \Silex\Application $app
     *
     * @return void
     */
    protected function defineControllers(Application $app): void
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

        $this->createController(
            '/adyen/callback/redirect-alipay',
            'adyen-redirect-alipay',
            static::BUNDLE_NAME,
            static::CALLBACK_CONTROLLER_NAME,
            'redirectAliPay'
        );

        $this->createController(
            '/adyen/callback/redirect-wechatpay',
            'adyen-redirect-wechatpay',
            static::BUNDLE_NAME,
            static::CALLBACK_CONTROLLER_NAME,
            'redirectWeChatPay'
        );
    }
}
