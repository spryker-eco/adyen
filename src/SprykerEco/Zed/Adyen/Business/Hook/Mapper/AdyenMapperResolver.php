<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Zed\Adyen\Business\Hook\Mapper;

use SprykerEco\Shared\Adyen\AdyenConfig as SharedAdyenConfig;
use SprykerEco\Zed\Adyen\AdyenConfig;
use SprykerEco\Zed\Adyen\Business\Exception\AdyenMethodMapperException;
use SprykerEco\Zed\Adyen\Business\Hook\Mapper\MakePayment\AdyenMapperInterface;

class AdyenMapperResolver implements AdyenMapperResolverInterface
{
    protected const CLASS_NAME_PATTERN = '\\SprykerEco\\Zed\\Adyen\\Business\\Hook\\Mapper\\MakePayment\\%sMapper';

    /**
     * @var \SprykerEco\Zed\Adyen\AdyenConfig
     */
    protected $config;

    /**
     * @param \SprykerEco\Zed\Adyen\AdyenConfig $config
     */
    public function __construct(AdyenConfig $config)
    {
        $this->config = $config;
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
        $className = $this->getMapperClassName($methodName);
        if (!class_exists($className)) {
            throw new AdyenMethodMapperException(
                sprintf('%s method mapper does not exist.', $methodName)
            );
        }

        return new $className($this->config);
    }

    /**
     * @param string $methodName
     *
     * @return string
     */
    protected function getMapperClassName(string $methodName): string
    {
        return sprintf(
            static::CLASS_NAME_PATTERN,
            str_replace(strtolower(SharedAdyenConfig::PROVIDER_NAME), '', $methodName)
        );
    }
}
