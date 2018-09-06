<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Service\Adyen;

use Spryker\Service\Kernel\AbstractServiceFactory;
use SprykerEco\Service\Adyen\Generator\AdyenGenerator;
use SprykerEco\Service\Adyen\Generator\AdyenGeneratorInterface;
use SprykerEco\Service\Adyen\Dependency\Service\AdyenToUtilTextServiceInterface;

/**
 * @method \SprykerEco\Service\Adyen\AdyenConfig getConfig()
 */
class AdyenServiceFactory extends AbstractServiceFactory
{
    /**
     * @return \SprykerEco\Service\Adyen\Generator\AdyenGeneratorInterface
     */
    public function createGenerator(): AdyenGeneratorInterface
    {
        return new AdyenGenerator($this->getUtilTextService());
    }

    /**
     * @return \SprykerEco\Service\Adyen\Dependency\Service\AdyenToUtilTextServiceInterface
     */
    public function getUtilTextService(): AdyenToUtilTextServiceInterface
    {
        return $this->getProvidedDependency(AdyenDependencyProvider::SERVICE_UTIL_TEXT);
    }
}
