<?php

/**
 * MIT License
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerEco\Zed\Adyen\Communication;

use Spryker\Zed\Kernel\Communication\AbstractCommunicationFactory;
use SprykerEco\Zed\Adyen\AdyenDependencyProvider;
use SprykerEco\Zed\Adyen\Dependency\Facade\AdyenToCalculationFacadeInterface;
use SprykerEco\Zed\Adyen\Dependency\Facade\AdyenToSalesFacadeInterface;

/**
 * @method \SprykerEco\Zed\Adyen\AdyenConfig getConfig()
 * @method \SprykerEco\Zed\Adyen\Business\AdyenFacadeInterface getFacade()
 * @method \SprykerEco\Zed\Adyen\Persistence\AdyenEntityManagerInterface getEntityManager()
 * @method \SprykerEco\Zed\Adyen\Persistence\AdyenRepositoryInterface getRepository()
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
