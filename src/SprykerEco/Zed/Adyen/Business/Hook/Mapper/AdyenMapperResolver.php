<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Zed\Adyen\Business\Hook\Mapper;

use SprykerEco\Zed\Adyen\Business\Exception\AdyenMethodMapperException;
use SprykerEco\Zed\Adyen\Business\Hook\Mapper\MakePayment\AdyenMapperInterface;

class AdyenMapperResolver implements AdyenMapperResolverInterface
{
    /**
     * @var array
     */
    protected $mappers;

    /**
     * @param array $mappers
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

        return $this->mappers[$methodName]();
    }
}
