<?php

/**
 * MIT License
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerEco\Zed\Adyen\Business\Hook\Mapper;

use SprykerEco\Zed\Adyen\Business\Hook\Mapper\MakePayment\AdyenMapperInterface;

interface AdyenMapperResolverInterface
{
    /**
     * @param string $methodName
     *
     * @return \SprykerEco\Zed\Adyen\Business\Hook\Mapper\MakePayment\AdyenMapperInterface
     */
    public function resolve(string $methodName): AdyenMapperInterface;
}
