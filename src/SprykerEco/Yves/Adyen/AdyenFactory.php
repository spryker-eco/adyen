<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Yves\Adyen;

use Spryker\Yves\Kernel\AbstractFactory;
use Spryker\Yves\StepEngine\Dependency\Form\StepEngineFormDataProviderInterface;
use Spryker\Yves\StepEngine\Dependency\Form\SubFormInterface;
use SprykerEco\Service\Adyen\AdyenServiceInterface;
use SprykerEco\Yves\Adyen\Dependency\Client\AdyenToQuoteClientInterface;
use SprykerEco\Yves\Adyen\Form\CreditCardSubForm;
use SprykerEco\Yves\Adyen\Form\DataProvider\CreditCardFormDataProvider;
use SprykerEco\Yves\Adyen\Handler\AdyenPaymentHandler;
use SprykerEco\Yves\Adyen\Handler\AdyenPaymentHandlerInterface;

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
     * @return \Spryker\Yves\StepEngine\Dependency\Form\StepEngineFormDataProviderInterface
     */
    public function createCreditCardFormDataProvider(): StepEngineFormDataProviderInterface
    {
        return new CreditCardFormDataProvider($this->getQuoteClient());
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
