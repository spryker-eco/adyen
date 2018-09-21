<?php

/**
 * MIT License
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerEco\Yves\Adyen;

use Generated\Shared\Transfer\PaymentTransfer;
use Spryker\Yves\Kernel\AbstractFactory;
use Spryker\Yves\StepEngine\Dependency\Form\StepEngineFormDataProviderInterface;
use Spryker\Yves\StepEngine\Dependency\Form\SubFormInterface;
use SprykerEco\Client\Adyen\AdyenClientInterface;
use SprykerEco\Service\Adyen\AdyenServiceInterface;
use SprykerEco\Yves\Adyen\Dependency\Client\AdyenToQuoteClientInterface;
use SprykerEco\Yves\Adyen\Dependency\Service\AdyenToUtilEncodingServiceInterface;
use SprykerEco\Yves\Adyen\Form\CreditCardSubForm;
use SprykerEco\Yves\Adyen\Form\DataProvider\CreditCardFormDataProvider;
use SprykerEco\Yves\Adyen\Form\DataProvider\DirectDebitFormDataProvider;
use SprykerEco\Yves\Adyen\Form\DataProvider\KlarnaInvoiceFormDataProvider;
use SprykerEco\Yves\Adyen\Form\DataProvider\SofortFormDataProvider;
use SprykerEco\Yves\Adyen\Form\DirectDebitSubForm;
use SprykerEco\Yves\Adyen\Form\KlarnaInvoiceSubForm;
use SprykerEco\Yves\Adyen\Form\SofortSubForm;
use SprykerEco\Yves\Adyen\Handler\AdyenPaymentHandler;
use SprykerEco\Yves\Adyen\Handler\AdyenPaymentHandlerInterface;
use SprykerEco\Yves\Adyen\Handler\Notification\AdyenNotificationHandler;
use SprykerEco\Yves\Adyen\Handler\Notification\AdyenNotificationHandlerInterface;
use SprykerEco\Yves\Adyen\Handler\Notification\Mapper\AdyenNotificationMapper;
use SprykerEco\Yves\Adyen\Handler\Notification\Mapper\AdyenNotificationMapperInterface;
use SprykerEco\Yves\Adyen\Handler\Redirect\AdyenRedirectHandlerInterface;
use SprykerEco\Yves\Adyen\Handler\Redirect\SofortRedirectHandler;
use SprykerEco\Yves\Adyen\Plugin\Payment\AdyenPaymentPluginInterface;
use SprykerEco\Yves\Adyen\Plugin\Payment\CreditCardPaymentPlugin;
use SprykerEco\Yves\Adyen\Plugin\Payment\KlarnaInvoicePaymentPlugin;

/**
 * @method \SprykerEco\Yves\Adyen\AdyenConfig getConfig()
 */
class AdyenFactory extends AbstractFactory
{
    /**
     * @return \SprykerEco\Yves\Adyen\Handler\AdyenPaymentHandlerInterface
     */
    public function createAdyenPaymentHandler(): AdyenPaymentHandlerInterface
    {
        return new AdyenPaymentHandler(
            $this->getAdyenService(),
            $this->getPaymentPlugins()
        );
    }

    /**
     * @return \Spryker\Yves\StepEngine\Dependency\Form\SubFormInterface
     */
    public function createCreditCardForm(): SubFormInterface
    {
        return new CreditCardSubForm();
    }

    /**
     * @return \Spryker\Yves\StepEngine\Dependency\Form\SubFormInterface
     */
    public function createSofortForm(): SubFormInterface
    {
        return new SofortSubForm();
    }

    /**
     * @return \Spryker\Yves\StepEngine\Dependency\Form\SubFormInterface
     */
    public function createDirectDebitForm(): SubFormInterface
    {
        return new DirectDebitSubForm();
    }

    /**
     * @return \Spryker\Yves\StepEngine\Dependency\Form\SubFormInterface
     */
    public function createKlarnaInvoiceForm(): SubFormInterface
    {
        return new KlarnaInvoiceSubForm();
    }

    /**
     * @return \Spryker\Yves\StepEngine\Dependency\Form\StepEngineFormDataProviderInterface
     */
    public function createCreditCardFormDataProvider(): StepEngineFormDataProviderInterface
    {
        return new CreditCardFormDataProvider($this->getQuoteClient());
    }

    /**
     * @return \Spryker\Yves\StepEngine\Dependency\Form\StepEngineFormDataProviderInterface
     */
    public function createSofortFormDataProvider(): StepEngineFormDataProviderInterface
    {
        return new SofortFormDataProvider($this->getQuoteClient());
    }

    /**
     * @return \Spryker\Yves\StepEngine\Dependency\Form\StepEngineFormDataProviderInterface
     */
    public function createDirectDebitFormDataProvider(): StepEngineFormDataProviderInterface
    {
        return new DirectDebitFormDataProvider($this->getQuoteClient());
    }

    /**
     * @return \Spryker\Yves\StepEngine\Dependency\Form\StepEngineFormDataProviderInterface
     */
    public function createKlarnaInvoiceFormDataProvider(): StepEngineFormDataProviderInterface
    {
        return new KlarnaInvoiceFormDataProvider($this->getQuoteClient());
    }

    /**
     * @return \SprykerEco\Yves\Adyen\Handler\Redirect\AdyenRedirectHandlerInterface
     */
    public function createSofortRedirectHandler(): AdyenRedirectHandlerInterface
    {
        return new SofortRedirectHandler(
            $this->getQuoteClient(),
            $this->getAdyenClient()
        );
    }

    /**
     * @return \SprykerEco\Yves\Adyen\Handler\Notification\AdyenNotificationHandlerInterface
     */
    public function createNotificationHandler(): AdyenNotificationHandlerInterface
    {
        return new AdyenNotificationHandler(
            $this->getAdyenClient(),
            $this->createNotificationMapper()
        );
    }

    /**
     * @return \SprykerEco\Yves\Adyen\Handler\Notification\Mapper\AdyenNotificationMapperInterface
     */
    public function createNotificationMapper(): AdyenNotificationMapperInterface
    {
        return new AdyenNotificationMapper($this->getUtilEncodingService());
    }

    /**
     * @return \SprykerEco\Yves\Adyen\Plugin\Payment\AdyenPaymentPluginInterface[]
     */
    public function getPaymentPlugins(): array
    {
        return [
            PaymentTransfer::ADYEN_CREDIT_CARD => $this->createCreditCardPaymentPlugin(),
            PaymentTransfer::ADYEN_KLARNA_INVOICE => $this->createKlarnaInvoicePaymentPlugin(),
        ];
    }

    /**
     * @return \SprykerEco\Yves\Adyen\Plugin\Payment\AdyenPaymentPluginInterface
     */
    public function createCreditCardPaymentPlugin(): AdyenPaymentPluginInterface
    {
        return new CreditCardPaymentPlugin();
    }

    /**
     * @return \SprykerEco\Yves\Adyen\Plugin\Payment\AdyenPaymentPluginInterface
     */
    public function createKlarnaInvoicePaymentPlugin(): AdyenPaymentPluginInterface
    {
        return new KlarnaInvoicePaymentPlugin();
    }

    /**
     * @return \SprykerEco\Client\Adyen\AdyenClientInterface
     */
    public function getAdyenClient(): AdyenClientInterface
    {
        return $this->getProvidedDependency(AdyenDependencyProvider::CLIENT_ADYEN);
    }

    /**
     * @return \SprykerEco\Service\Adyen\AdyenServiceInterface
     */
    public function getAdyenService(): AdyenServiceInterface
    {
        return $this->getProvidedDependency(AdyenDependencyProvider::SERVICE_ADYEN);
    }

    /**
     * @return \SprykerEco\Yves\Adyen\Dependency\Client\AdyenToQuoteClientInterface
     */
    public function getQuoteClient(): AdyenToQuoteClientInterface
    {
        return $this->getProvidedDependency(AdyenDependencyProvider::CLIENT_QUOTE);
    }

    /**
     * @return \SprykerEco\Yves\Adyen\Dependency\Service\AdyenToUtilEncodingServiceInterface
     */
    public function getUtilEncodingService(): AdyenToUtilEncodingServiceInterface
    {
        return $this->getProvidedDependency(AdyenDependencyProvider::SERVICE_UTIL_ENCODING);
    }
}
