<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Zed\Adyen;

use Spryker\Zed\Kernel\AbstractBundleDependencyProvider;
use Spryker\Zed\Kernel\Container;
use SprykerEco\Zed\Adyen\Dependency\Facade\AdyenToAdyenApiFacadeBridge;

class AdyenDependencyProvider extends AbstractBundleDependencyProvider
{
    public const FACADE_ADYEN_API = 'FACADE_ADYEN_API';

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    public function provideCommunicationLayerDependencies(Container $container): Container
    {
        return $container;
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    public function provideBusinessLayerDependencies(Container $container): Container
    {
        $container = parent::provideBusinessLayerDependencies($container);
        $container = $this->addAdyenApiFacade($container);

        return $container;
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    protected function addAdyenApiFacade(Container $container): Container
    {
        $container[static::FACADE_ADYEN_API] = function (Container $container) {
            return new AdyenToAdyenApiFacadeBridge($container->getLocator()->adyenApi()->facade());
        };

        return $container;
    }
}
