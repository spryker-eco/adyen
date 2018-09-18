<?php

/**
 * MIT License
 * For full license information, please view the LICENSE file that was distributed with this source code.
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
