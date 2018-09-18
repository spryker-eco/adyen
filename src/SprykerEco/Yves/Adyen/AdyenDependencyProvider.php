<?php

/**
 * MIT License
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerEco\Yves\Adyen;

use Spryker\Yves\Kernel\AbstractBundleDependencyProvider;
use Spryker\Yves\Kernel\Container;
use SprykerEco\Yves\Adyen\Dependency\Client\AdyenToQuoteClientBridge;

class AdyenDependencyProvider extends AbstractBundleDependencyProvider
{
    public const CLIENT_QUOTE = 'CLIENT_QUOTE';
    public const CLIENT_ADYEN = 'CLIENT_ADYEN';

    public const SERVICE_ADYEN = 'SERVICE_ADYEN';

    /**
     * @param \Spryker\Yves\Kernel\Container $container
     *
     * @return \Spryker\Yves\Kernel\Container
     */
    public function provideDependencies(Container $container): Container
    {
        $container = parent::provideDependencies($container);
        $container = $this->addAdyenClient($container);
        $container = $this->addQuoteClient($container);
        $container = $this->addAdyenService($container);

        return $container;
    }

    /**
     * @param \Spryker\Yves\Kernel\Container $container
     *
     * @return \Spryker\Yves\Kernel\Container
     */
    protected function addAdyenClient(Container $container): Container
    {
        $container[static::CLIENT_ADYEN] = function (Container $container) {
            return $container->getLocator()->adyen()->client();
        };

        return $container;
    }

    /**
     * @param \Spryker\Yves\Kernel\Container $container
     *
     * @return \Spryker\Yves\Kernel\Container
     */
    protected function addQuoteClient(Container $container): Container
    {
        $container[static::CLIENT_QUOTE] = function (Container $container) {
            return new AdyenToQuoteClientBridge($container->getLocator()->quote()->client());
        };

        return $container;
    }

    /**
     * @param \Spryker\Yves\Kernel\Container $container
     *
     * @return \Spryker\Yves\Kernel\Container
     */
    protected function addAdyenService(Container $container): Container
    {
        $container[static::SERVICE_ADYEN] = function (Container $container) {
            return $container->getLocator()->adyen()->service();
        };

        return $container;
    }
}
