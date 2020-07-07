<?php

/**
 * MIT License
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerEco\Yves\Adyen;

use Spryker\Yves\Kernel\AbstractBundleDependencyProvider;
use Spryker\Yves\Kernel\Container;
use SprykerEco\Yves\Adyen\Dependency\Client\AdyenToQuoteClientBridge;
use SprykerEco\Yves\Adyen\Dependency\Service\AdyenToUtilEncodingServiceBridge;
use SprykerEco\Yves\Adyen\Plugin\Payment\CreditCardPaymentMapperPlugin;
use SprykerEco\Yves\Adyen\Plugin\Payment\KlarnaInvoicePaymentMapperPlugin;

class AdyenDependencyProvider extends AbstractBundleDependencyProvider
{
    public const CLIENT_QUOTE = 'CLIENT_QUOTE';
    public const CLIENT_ADYEN = 'CLIENT_ADYEN';

    public const SERVICE_ADYEN = 'SERVICE_ADYEN';
    public const SERVICE_UTIL_ENCODING = 'SERVICE_UTIL_ENCODING';

    public const PLUGINS_ADYEN_PAYMENT = 'PLUGINS_ADYEN_PAYMENT';

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
        $container = $this->addUtilEncodingService($container);
        $container = $this->addAdyenPaymentPlugins($container);

        return $container;
    }

    /**
     * @param \Spryker\Yves\Kernel\Container $container
     *
     * @return \Spryker\Yves\Kernel\Container
     */
    protected function addAdyenClient(Container $container): Container
    {
        $container->set(static::CLIENT_ADYEN, function (Container $container) {
            return $container->getLocator()->adyen()->client();
        });

        return $container;
    }

    /**
     * @param \Spryker\Yves\Kernel\Container $container
     *
     * @return \Spryker\Yves\Kernel\Container
     */
    protected function addQuoteClient(Container $container): Container
    {
        $container->set(static::CLIENT_QUOTE, function (Container $container) {
            return new AdyenToQuoteClientBridge($container->getLocator()->quote()->client());
        });

        return $container;
    }

    /**
     * @param \Spryker\Yves\Kernel\Container $container
     *
     * @return \Spryker\Yves\Kernel\Container
     */
    protected function addAdyenService(Container $container): Container
    {
        $container->set(static::SERVICE_ADYEN, function (Container $container) {
            return $container->getLocator()->adyen()->service();
        });

        return $container;
    }

    /**
     * @param \Spryker\Yves\Kernel\Container $container
     *
     * @return \Spryker\Yves\Kernel\Container
     */
    protected function addUtilEncodingService(Container $container): Container
    {
        $container->set(static::SERVICE_UTIL_ENCODING, function (Container $container) {
            return new AdyenToUtilEncodingServiceBridge($container->getLocator()->utilEncoding()->service());
        });

        return $container;
    }

    /**
     * @param \Spryker\Yves\Kernel\Container $container
     *
     * @return \Spryker\Yves\Kernel\Container
     */
    protected function addAdyenPaymentPlugins(Container $container): Container
    {
        $container->set(static::PLUGINS_ADYEN_PAYMENT, function () {
            return $this->getAdyenPaymentPlugins();
        });

        return $container;
    }

    /**
     * @return \SprykerEco\Yves\Adyen\Plugin\Payment\AdyenPaymentMapperPluginInterface[]
     */
    protected function getAdyenPaymentPlugins(): array
    {
        return [
            new CreditCardPaymentMapperPlugin(),
            new KlarnaInvoicePaymentMapperPlugin(),
        ];
    }
}
