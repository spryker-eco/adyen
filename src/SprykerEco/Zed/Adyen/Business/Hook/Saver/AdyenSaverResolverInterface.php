<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Zed\Adyen\Business\Hook\Saver;

use SprykerEco\Zed\Adyen\Business\Hook\Saver\MakePayment\AdyenSaverInterface;

interface AdyenSaverResolverInterface
{
    /**
     * @param string $methodName
     *
     * @return \SprykerEco\Zed\Adyen\Business\Hook\Saver\MakePayment\AdyenSaverInterface
     */
    public function resolve(string $methodName): AdyenSaverInterface;
}
