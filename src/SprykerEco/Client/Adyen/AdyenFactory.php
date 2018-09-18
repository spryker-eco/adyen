<?php

/**
 * MIT License
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerEco\Client\Adyen;

use Spryker\Client\Kernel\AbstractFactory;
use Spryker\Client\ZedRequest\ZedRequestClientInterface;
use SprykerEco\Client\Adyen\Zed\AdyenStub;
use SprykerEco\Client\Adyen\Zed\AdyenStubInterface;

class AdyenFactory extends AbstractFactory
{
    /**
     * @return \SprykerEco\Client\Adyen\Zed\AdyenStubInterface
     */
    public function createZedStub(): AdyenStubInterface
    {
        return new AdyenStub($this->getServiceZed());
    }

    /**
     * @return \Spryker\Client\ZedRequest\ZedRequestClientInterface
     */
    public function getServiceZed(): ZedRequestClientInterface
    {
        return $this->getProvidedDependency(AdyenDependencyProvider::SERVICE_ZED);
    }
}
