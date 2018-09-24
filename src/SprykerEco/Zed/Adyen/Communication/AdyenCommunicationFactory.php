<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Zed\Adyen\Communication;

use Spryker\Zed\Kernel\Communication\AbstractCommunicationFactory;
use SprykerEco\Zed\Adyen\AdyenDependencyProvider;
use SprykerEco\Zed\Adyen\Dependency\Facade\AdyenToCalculationFacadeInterface;
use SprykerEco\Zed\Adyen\Dependency\Facade\AdyenToSalesFacadeInterface;

/**
 * @method \SprykerEco\Zed\Adyen\AdyenConfig getConfig()
 */
class AdyenCommunicationFactory extends AbstractCommunicationFactory
{
    /**
     * @return \SprykerEco\Zed\Adyen\Dependency\Facade\AdyenToSalesFacadeInterface
     */
    public function getSalesFacade(): AdyenToSalesFacadeInterface
    {
        return $this->getProvidedDependency(AdyenDependencyProvider::FACADE_SALES);
    }

    /**
     * @return \SprykerEco\Zed\Adyen\Dependency\Facade\AdyenToCalculationFacadeInterface
     */
    public function getCalculationFacade(): AdyenToCalculationFacadeInterface
    {
        return $this->getProvidedDependency(AdyenDependencyProvider::FACADE_CALCULATION);
    }
}
