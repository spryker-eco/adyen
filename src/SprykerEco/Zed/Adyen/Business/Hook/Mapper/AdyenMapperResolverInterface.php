<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
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
