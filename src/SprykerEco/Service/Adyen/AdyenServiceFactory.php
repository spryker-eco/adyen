<?php

/**
 * MIT License
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerEco\Service\Adyen;

use Spryker\Service\Kernel\AbstractServiceFactory;
use SprykerEco\Service\Adyen\Dependency\Service\AdyenToUtilTextServiceInterface;
use SprykerEco\Service\Adyen\Generator\AdyenGenerator;
use SprykerEco\Service\Adyen\Generator\AdyenGeneratorInterface;

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
