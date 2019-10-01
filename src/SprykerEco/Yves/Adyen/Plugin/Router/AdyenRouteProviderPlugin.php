<?php

/**
 * MIT License
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerEco\Yves\Adyen\Plugin\Router;

use Spryker\Yves\Router\Plugin\RouteProvider\AbstractRouteProviderPlugin;
use Spryker\Yves\Router\Route\RouteCollection;

class AdyenRouteProviderPlugin extends AbstractRouteProviderPlugin
{
    protected const BUNDLE_NAME = 'Adyen';
    protected const CALLBACK_CONTROLLER_NAME = 'Callback';
    protected const NOTIFICATION_CONTROLLER_NAME = 'Notification';

    protected const ROUTE_NOTIFICATION_PATH = '/adyen/notification';
    protected const ROUTE_REDIRECT_SOFORT_PATH = '/adyen/callback/redirect-sofort';
    protected const ROUTE_REDIRECT_CREDIT_CARD_3D_PATH = '/adyen/callback/redirect-credit-card-3d';
    protected const ROUTE_REDIRECT_IDEAL_PATH = '/adyen/callback/redirect-ideal';
    protected const ROUTE_REDIRECT_PAYPAL_PATH = '/adyen/callback/redirect-paypal';
    protected const ROUTE_REDIRECT_ALIPAY_PATH = '/adyen/callback/redirect-alipay';
    protected const ROUTE_REDIRECT_WECHATPAY_PATH = '/adyen/callback/redirect-wechatpay';

    protected const ROUTE_NOTIFICATION_NAME = 'adyen-notification';
    protected const ROUTE_REDIRECT_SOFORT_NAME = 'adyen-redirect-sofort';
    protected const ROUTE_REDIRECT_CREDIT_CARD_3D_NAME = 'adyen-redirect-credit-card-3d';
    protected const ROUTE_REDIRECT_IDEAL_NAME = 'adyen-redirect-ideal';
    protected const ROUTE_REDIRECT_PAYPAL_NAME = 'adyen-redirect-paypal';
    protected const ROUTE_REDIRECT_ALIPAY_NAME = 'adyen-redirect-alipay';
    protected const ROUTE_REDIRECT_WECHATPAY_NAME = 'adyen-redirect-wechatpay';

    protected const ROUTE_NOTIFICATION_ACTION = 'indexAction';
    protected const ROUTE_REDIRECT_SOFORT_ACTION = 'redirectSofort';
    protected const ROUTE_REDIRECT_CREDIT_CARD_3D_ACTION = 'redirectCreditCard3d';
    protected const ROUTE_REDIRECT_IDEAL_ACTION = 'redirectIdeal';
    protected const ROUTE_REDIRECT_PAYPAL_ACTION = 'redirectPayPal';
    protected const ROUTE_REDIRECT_ALIPAY_ACTION = 'redirectAliPay';
    protected const ROUTE_REDIRECT_WECHATPAY_ACTION = 'redirectWeChatPay';

    /**
     * Specification:
     * - Adds Adyen specific Routes to the RouteCollection.
     *
     * @api
     *
     * @param \Spryker\Yves\Router\Route\RouteCollection $routeCollection
     *
     * @return \Spryker\Yves\Router\Route\RouteCollection
     */
    public function addRoutes(RouteCollection $routeCollection): RouteCollection
    {
        $routeCollection = $this->addNotificationRoute($routeCollection);
        $routeCollection = $this->addRedirectSofortRoute($routeCollection);
        $routeCollection = $this->addRedirectCreditCard3DRoute($routeCollection);
        $routeCollection = $this->addRedirectIdealRoute($routeCollection);
        $routeCollection = $this->addRedirectPayPalRoute($routeCollection);
        $routeCollection = $this->addRedirectAliPayRoute($routeCollection);
        $routeCollection = $this->addRedirectWeChatPayRoute($routeCollection);

        return $routeCollection;
    }

    /**
     * @uses \SprykerEco\Yves\Adyen\Controller\NotificationController::indexAction()
     *
     * @param \Spryker\Yves\Router\Route\RouteCollection $routeCollection
     *
     * @return \Spryker\Yves\Router\Route\RouteCollection
     */
    protected function addNotificationRoute(RouteCollection $routeCollection): RouteCollection
    {
        $route = $this->buildRoute(
            static::ROUTE_NOTIFICATION_PATH,
            static::BUNDLE_NAME,
            static::NOTIFICATION_CONTROLLER_NAME,
            static::ROUTE_NOTIFICATION_ACTION
        );
        $routeCollection->add(static::ROUTE_NOTIFICATION_NAME, $route);

        return $routeCollection;
    }

    /**
     * @uses \SprykerEco\Yves\Adyen\Controller\CallbackController::redirectSofortAction()
     *
     * @param \Spryker\Yves\Router\Route\RouteCollection $routeCollection
     *
     * @return \Spryker\Yves\Router\Route\RouteCollection
     */
    protected function addRedirectSofortRoute(RouteCollection $routeCollection): RouteCollection
    {
        $route = $this->buildRoute(
            static::ROUTE_REDIRECT_SOFORT_PATH,
            static::BUNDLE_NAME,
            static::CALLBACK_CONTROLLER_NAME,
            static::ROUTE_REDIRECT_SOFORT_ACTION
        );
        $route = $route->setMethods(['GET', 'POST']);
        $routeCollection->add(static::ROUTE_REDIRECT_SOFORT_NAME, $route);

        return $routeCollection;
    }

    /**
     * @uses \SprykerEco\Yves\Adyen\Controller\CallbackController::redirectCreditCard3dAction()
     *
     * @param \Spryker\Yves\Router\Route\RouteCollection $routeCollection
     *
     * @return \Spryker\Yves\Router\Route\RouteCollection
     */
    protected function addRedirectCreditCard3DRoute(RouteCollection $routeCollection): RouteCollection
    {
        $route = $this->buildRoute(
            static::ROUTE_REDIRECT_CREDIT_CARD_3D_PATH,
            static::BUNDLE_NAME,
            static::CALLBACK_CONTROLLER_NAME,
            static::ROUTE_REDIRECT_CREDIT_CARD_3D_ACTION
        );
        $routeCollection->add(static::ROUTE_REDIRECT_CREDIT_CARD_3D_NAME, $route);

        return $routeCollection;
    }

    /**
     * @uses \SprykerEco\Yves\Adyen\Controller\CallbackController::redirectIdealAction()
     *
     * @param \Spryker\Yves\Router\Route\RouteCollection $routeCollection
     *
     * @return \Spryker\Yves\Router\Route\RouteCollection
     */
    protected function addRedirectIdealRoute(RouteCollection $routeCollection): RouteCollection
    {
        $route = $this->buildRoute(
            static::ROUTE_REDIRECT_IDEAL_PATH,
            static::BUNDLE_NAME,
            static::CALLBACK_CONTROLLER_NAME,
            static::ROUTE_REDIRECT_IDEAL_ACTION
        );
        $routeCollection->add(static::ROUTE_REDIRECT_IDEAL_NAME, $route);

        return $routeCollection;
    }

    /**
     * @uses \SprykerEco\Yves\Adyen\Controller\CallbackController::redirectPayPalAction()
     *
     * @param \Spryker\Yves\Router\Route\RouteCollection $routeCollection
     *
     * @return \Spryker\Yves\Router\Route\RouteCollection
     */
    protected function addRedirectPayPalRoute(RouteCollection $routeCollection): RouteCollection
    {
        $route = $this->buildRoute(
            static::ROUTE_REDIRECT_PAYPAL_PATH,
            static::BUNDLE_NAME,
            static::CALLBACK_CONTROLLER_NAME,
            static::ROUTE_REDIRECT_PAYPAL_ACTION
        );
        $routeCollection->add(static::ROUTE_REDIRECT_PAYPAL_NAME, $route);

        return $routeCollection;
    }

    /**
     * @uses \SprykerEco\Yves\Adyen\Controller\CallbackController::redirectAliPayAction()
     *
     * @param \Spryker\Yves\Router\Route\RouteCollection $routeCollection
     *
     * @return \Spryker\Yves\Router\Route\RouteCollection
     */
    protected function addRedirectAliPayRoute(RouteCollection $routeCollection): RouteCollection
    {
        $route = $this->buildRoute(
            static::ROUTE_REDIRECT_ALIPAY_PATH,
            static::BUNDLE_NAME,
            static::CALLBACK_CONTROLLER_NAME,
            static::ROUTE_REDIRECT_ALIPAY_ACTION
        );
        $routeCollection->add(static::ROUTE_REDIRECT_ALIPAY_NAME, $route);

        return $routeCollection;
    }

    /**
     * @uses \SprykerEco\Yves\Adyen\Controller\CallbackController::redirectWeChatPayAction()
     *
     * @param \Spryker\Yves\Router\Route\RouteCollection $routeCollection
     *
     * @return \Spryker\Yves\Router\Route\RouteCollection
     */
    protected function addRedirectWeChatPayRoute(RouteCollection $routeCollection): RouteCollection
    {
        $route = $this->buildRoute(
            static::ROUTE_REDIRECT_WECHATPAY_PATH,
            static::BUNDLE_NAME,
            static::CALLBACK_CONTROLLER_NAME,
            static::ROUTE_REDIRECT_WECHATPAY_ACTION
        );
        $routeCollection->add(static::ROUTE_REDIRECT_WECHATPAY_NAME, $route);

        return $routeCollection;
    }
}
