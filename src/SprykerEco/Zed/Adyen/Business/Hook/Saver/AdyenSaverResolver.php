<?php

/**
 * MIT License
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerEco\Zed\Adyen\Business\Hook\Saver;

use SprykerEco\Zed\Adyen\Business\Exception\AdyenMethodSaverException;
use SprykerEco\Zed\Adyen\Business\Hook\Saver\MakePayment\AdyenSaverInterface;

class AdyenSaverResolver implements AdyenSaverResolverInterface
{
    /**
     * @var array<\SprykerEco\Zed\Adyen\Business\Hook\Saver\MakePayment\AdyenSaverInterface>
     */
    protected $savers = [];

    /**
     * @param array<\SprykerEco\Zed\Adyen\Business\Hook\Saver\MakePayment\AdyenSaverInterface> $savers
     */
    public function __construct(array $savers)
    {
        $this->savers = $savers;
    }

    /**
     * @param string $methodName
     *
     * @throws \SprykerEco\Zed\Adyen\Business\Exception\AdyenMethodSaverException
     *
     * @return \SprykerEco\Zed\Adyen\Business\Hook\Saver\MakePayment\AdyenSaverInterface
     */
    public function resolve(string $methodName): AdyenSaverInterface
    {
        if (!array_key_exists($methodName, $this->savers)) {
            throw new AdyenMethodSaverException(
                sprintf('%s method saver is not registered.', $methodName),
            );
        }

        return $this->savers[$methodName];
    }
}
