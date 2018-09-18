<?php

/**
 * MIT License
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerEco\Yves\Adyen;

use Spryker\Yves\Kernel\AbstractFactory;
use Spryker\Yves\StepEngine\Dependency\Form\StepEngineFormDataProviderInterface;
use Spryker\Yves\StepEngine\Dependency\Form\SubFormInterface;
use SprykerEco\Client\Adyen\AdyenClientInterface;
use SprykerEco\Service\Adyen\AdyenServiceInterface;
use SprykerEco\Yves\Adyen\Dependency\Client\AdyenToQuoteClientInterface;
use SprykerEco\Yves\Adyen\Form\CreditCardSubForm;
use SprykerEco\Yves\Adyen\Form\DataProvider\CreditCardFormDataProvider;
use SprykerEco\Yves\Adyen\Form\DataProvider\DirectDebitFormDataProvider;
use SprykerEco\Yves\Adyen\Form\DataProvider\SofortFormDataProvider;
use SprykerEco\Yves\Adyen\Form\DirectDebitSubForm;
use SprykerEco\Yves\Adyen\Form\SofortSubForm;
use SprykerEco\Yves\Adyen\Handler\AdyenPaymentHandler;
use SprykerEco\Yves\Adyen\Handler\AdyenPaymentHandlerInterface;
use SprykerEco\Yves\Adyen\Handler\Redirect\AdyenRedirectHandlerInterface;
use SprykerEco\Yves\Adyen\Handler\Redirect\SofortRedirectHandler;

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
        return new AdyenPaymentHandler($this->getAdyenService());
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
}
