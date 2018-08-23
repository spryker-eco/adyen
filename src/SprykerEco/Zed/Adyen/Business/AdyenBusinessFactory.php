<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Zed\Adyen\Business;

use Spryker\Zed\Kernel\Business\AbstractBusinessFactory;
use SprykerEco\Zed\Adyen\AdyenDependencyProvider;
use SprykerEco\Zed\Adyen\Business\Payment\AdyenPaymentMethodFilter;
use SprykerEco\Zed\Adyen\Business\Payment\AdyenPaymentMethodFilterInterface;
use SprykerEco\Zed\Adyen\Dependency\Facade\AdyenToAdyenApiFacadeInterface;

/**
 * @method \SprykerEco\Zed\Adyen\AdyenConfig getConfig()
 */
class AdyenBusinessFactory extends AbstractBusinessFactory
{
    /**
     * @return \SprykerEco\Zed\Adyen\Business\Payment\AdyenPaymentMethodFilterInterface
     */
    public function createPaymentMethodsFilter(): AdyenPaymentMethodFilterInterface
    {
        return new AdyenPaymentMethodFilter($this->getAdyenApiFacade());
    }

    /**
     * @return \SprykerEco\Zed\Adyen\Dependency\Facade\AdyenToAdyenApiFacadeInterface
     */
    public function getAdyenApiFacade(): AdyenToAdyenApiFacadeInterface
    {
        return $this->getProvidedDependency(AdyenDependencyProvider::FACADE_ADYEN_API);
    }
}
