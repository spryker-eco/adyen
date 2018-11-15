<?php

/**
 * MIT License
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerEco\Client\Adyen;

use Spryker\Client\Kernel\AbstractFactory;
use SprykerEco\Client\Adyen\Dependency\Client\AdyenToZedRequestClientInterface;
use SprykerEco\Client\Adyen\Zed\AdyenStub;
use SprykerEco\Client\Adyen\Zed\AdyenStubInterface;

class AdyenFactory extends AbstractFactory
{
    /**
     * @return \SprykerEco\Client\Adyen\Zed\AdyenStubInterface
     */
    public function createZedAdyenStub(): AdyenStubInterface
    {
        return new AdyenStub($this->getZedRequestClient());
    }

    /**
     * @return \SprykerEco\Client\Adyen\Dependency\Client\AdyenToZedRequestClientInterface
     */
    public function getZedRequestClient(): AdyenToZedRequestClientInterface
    {
        return $this->getProvidedDependency(AdyenDependencyProvider::CLIENT_ZED_REQUEST);
    }
}
