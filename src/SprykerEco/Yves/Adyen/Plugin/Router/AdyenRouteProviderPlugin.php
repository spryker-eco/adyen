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

    /**
     * {@inheritDoc}
     *
     * @param \Spryker\Yves\Router\Route\RouteCollection $routeCollection
     *
     * @return \Spryker\Yves\Router\Route\RouteCollection
     */
    public function addRoutes(RouteCollection $routeCollection): RouteCollection
    {
        $routeCollection = $this->addAdyenNotificationRoute($routeCollection);
        $routeCollection = $this->addAdyenRedirectSofortRoute($routeCollection);
        $routeCollection = $this->addAdyenRedirectCard3dRoute($routeCollection);
        $routeCollection = $this->addAdyenRedirectIdealRoute($routeCollection);
        $routeCollection = $this->addAdyenRedirectPaypalRoute($routeCollection);
        $routeCollection = $this->addAdyenRedirectAlipayRoute($routeCollection);
        $routeCollection = $this->addAdyenRedirectWechatPayRoute($routeCollection);
        $routeCollection = $this->addAdyenRedirectKlarnaRoute($routeCollection);

        return $routeCollection;
    }

    /**
     * @param \Spryker\Yves\Router\Route\RouteCollection $routeCollection
     *
     * @return \Spryker\Yves\Router\Route\RouteCollection
     */
    protected function addAdyenNotificationRoute(RouteCollection $routeCollection): RouteCollection
    {
        $routeCollection->add(
            'adyen-notification',
            $this->buildPostRoute('/adyen/notification', static::BUNDLE_NAME, static::NOTIFICATION_CONTROLLER_NAME, 'index')
        );

        return $routeCollection;
    }

    /**
     * @param \Spryker\Yves\Router\Route\RouteCollection $routeCollection
     *
     * @return \Spryker\Yves\Router\Route\RouteCollection
     */
    protected function addAdyenRedirectSofortRoute(RouteCollection $routeCollection): RouteCollection
    {
        $routeCollection->add(
            'adyen-redirect-sofort',
            $this->buildRoute('/adyen/callback/redirect-sofort', static::BUNDLE_NAME, static::CALLBACK_CONTROLLER_NAME, 'redirectSofort')
        );

        return $routeCollection;
    }

    /**
     * @param \Spryker\Yves\Router\Route\RouteCollection $routeCollection
     *
     * @return \Spryker\Yves\Router\Route\RouteCollection
     */
    protected function addAdyenRedirectCard3dRoute(RouteCollection $routeCollection): RouteCollection
    {
        $routeCollection->add(
            'adyen-redirect-credit-card-3d',
            $this->buildRoute('/adyen/callback/redirect-credit-card-3d', static::BUNDLE_NAME, static::CALLBACK_CONTROLLER_NAME, 'redirectCreditCard3d')
        );

        return $routeCollection;
    }

    /**
     * @param \Spryker\Yves\Router\Route\RouteCollection $routeCollection
     *
     * @return \Spryker\Yves\Router\Route\RouteCollection
     */
    protected function addAdyenRedirectIdealRoute(RouteCollection $routeCollection): RouteCollection
    {
        $routeCollection->add(
            'adyen-redirect-ideal',
            $this->buildRoute('/adyen/callback/redirect-ideal', static::BUNDLE_NAME, static::CALLBACK_CONTROLLER_NAME, 'redirectIdeal')
        );

        return $routeCollection;
    }

    /**
     * @param \Spryker\Yves\Router\Route\RouteCollection $routeCollection
     *
     * @return \Spryker\Yves\Router\Route\RouteCollection
     */
    protected function addAdyenRedirectPaypalRoute(RouteCollection $routeCollection): RouteCollection
    {
        $routeCollection->add(
            'adyen-redirect-paypal',
            $this->buildRoute('/adyen/callback/redirect-paypal', static::BUNDLE_NAME, static::CALLBACK_CONTROLLER_NAME, 'redirectPayPal')
        );

        return $routeCollection;
    }

    /**
     * @param \Spryker\Yves\Router\Route\RouteCollection $routeCollection
     *
     * @return \Spryker\Yves\Router\Route\RouteCollection
     */
    protected function addAdyenRedirectAlipayRoute(RouteCollection $routeCollection): RouteCollection
    {
        $routeCollection->add(
            'adyen-redirect-alipay',
            $this->buildRoute('/adyen/callback/redirect-alipay', static::BUNDLE_NAME, static::CALLBACK_CONTROLLER_NAME, 'redirectAliPay')
        );

        return $routeCollection;
    }

    /**
     * @param \Spryker\Yves\Router\Route\RouteCollection $routeCollection
     *
     * @return \Spryker\Yves\Router\Route\RouteCollection
     */
    protected function addAdyenRedirectWechatPayRoute(RouteCollection $routeCollection): RouteCollection
    {
        $routeCollection->add(
            'adyen-redirect-wechatpay',
            $this->buildRoute('/adyen/callback/redirect-wechatpay', static::BUNDLE_NAME, static::CALLBACK_CONTROLLER_NAME, 'redirectWeChatPay')
        );

        return $routeCollection;
    }

    /**
     * @param \Spryker\Yves\Router\Route\RouteCollection $routeCollection
     *
     * @return \Spryker\Yves\Router\Route\RouteCollection
     */
    protected function addAdyenRedirectKlarnaRoute(RouteCollection $routeCollection): RouteCollection
    {
        $routeCollection->add(
            'adyen-redirect-klarna',
            $this->buildRoute('/adyen/callback/redirect-klarna', static::BUNDLE_NAME, static::CALLBACK_CONTROLLER_NAME, 'redirectKlarna')
        );

        return $routeCollection;
    }
}
