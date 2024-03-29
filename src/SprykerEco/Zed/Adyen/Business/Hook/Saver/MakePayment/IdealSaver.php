<?php

/**
 * MIT License
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerEco\Zed\Adyen\Business\Hook\Saver\MakePayment;

class IdealSaver extends AbstractSaver
{
    /**
     * @var string
     */
    protected const MAKE_PAYMENT_IDEAL_REQUEST_TYPE = 'MakePayment[iDeal]';

    /**
     * @return string
     */
    protected function getRequestType(): string
    {
        return static::MAKE_PAYMENT_IDEAL_REQUEST_TYPE;
    }
}
