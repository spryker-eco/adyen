<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Zed\Adyen;

use Spryker\Zed\Kernel\AbstractBundleDependencyProvider;
use Spryker\Zed\Kernel\Container;
use SprykerEco\Zed\Adyen\Dependency\Facade\AdyenToAdyenApiFacadeBridge;
use SprykerEco\Zed\Adyen\Dependency\Facade\AdyenToCalculationFacadeBridge;
use SprykerEco\Zed\Adyen\Dependency\Facade\AdyenToOmsFacadeBridge;
use SprykerEco\Zed\Adyen\Dependency\Facade\AdyenToSalesFacadeBridge;
use SprykerEco\Zed\Adyen\Dependency\Service\AdyenToUtilEncodingServiceBridge;

class AdyenDependencyProvider extends AbstractBundleDependencyProvider
{
    public const FACADE_ADYEN_API = 'FACADE_ADYEN_API';
    public const FACADE_SALES = 'FACADE_SALES';
    public const FACADE_CALCULATION = 'FACADE_CALCULATION';
    public const FACADE_OMS = 'FACADE_OMS';

    public const SERVICE_UTIL_ENCODING = 'SERVICE_UTIL_ENCODING';

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    public function provideCommunicationLayerDependencies(Container $container): Container
    {
        $container = parent::provideCommunicationLayerDependencies($container);
        $container = $this->addSalesFacade($container);
        $container = $this->addCalculationFacade($container);

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
        $container = $this->addOmsFacade($container);
        $container = $this->addUtilEncodingService($container);

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

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    protected function addSalesFacade(Container $container): Container
    {
        $container[static::FACADE_SALES] = function (Container $container) {
            return new AdyenToSalesFacadeBridge($container->getLocator()->sales()->facade());
        };

        return $container;
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    protected function addCalculationFacade(Container $container): Container
    {
        $container[static::FACADE_CALCULATION] = function (Container $container) {
            return new AdyenToCalculationFacadeBridge($container->getLocator()->calculation()->facade());
        };

        return $container;
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    protected function addOmsFacade(Container $container): Container
    {
        $container[static::FACADE_OMS] = function (Container $container) {
            return new AdyenToOmsFacadeBridge($container->getLocator()->oms()->facade());
        };

        return $container;
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    protected function addUtilEncodingService(Container $container): Container
    {
        $container[static::SERVICE_UTIL_ENCODING] = function (Container $container) {
            return new AdyenToUtilEncodingServiceBridge($container->getLocator()->utilEncoding()->service());
        };

        return $container;
    }
}
