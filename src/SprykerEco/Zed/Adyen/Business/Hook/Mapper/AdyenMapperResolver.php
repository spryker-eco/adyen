<?php

/**
 * MIT License
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerEco\Zed\Adyen\Business\Hook\Mapper;

use SprykerEco\Zed\Adyen\Business\Exception\AdyenMethodMapperException;
use SprykerEco\Zed\Adyen\Business\Hook\Mapper\MakePayment\AdyenMapperInterface;

class AdyenMapperResolver implements AdyenMapperResolverInterface
{
    /**
     * @var \SprykerEco\Zed\Adyen\Business\Hook\Mapper\MakePayment\AdyenMapperInterface[]
     */
    protected $mappers;

    /**
     * @param \SprykerEco\Zed\Adyen\Business\Hook\Mapper\MakePayment\AdyenMapperInterface[] $mappers
     */
    public function __construct(array $mappers)
    {
        $this->mappers = $mappers;
    }

    /**
     * @param string $methodName
     *
     * @throws \SprykerEco\Zed\Adyen\Business\Exception\AdyenMethodMapperException
     *
     * @return \SprykerEco\Zed\Adyen\Business\Hook\Mapper\MakePayment\AdyenMapperInterface
     */
    public function resolve(string $methodName): AdyenMapperInterface
    {
        if (!array_key_exists($methodName, $this->mappers)) {
            throw new AdyenMethodMapperException(
                sprintf('%s method mapper is not registered.', $methodName)
            );
        }

        return $this->mappers[$methodName];
    }
}
