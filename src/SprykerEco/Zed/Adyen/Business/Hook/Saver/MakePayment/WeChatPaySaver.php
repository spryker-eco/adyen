<?php

/**
 * MIT License
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerEco\Zed\Adyen\Business\Hook\Saver\MakePayment;

class WeChatPaySaver extends AbstractSaver
{
    protected const MAKE_PAYMENT_PAY_PAL_REQUEST_TYPE = 'MakePayment[WeChatPay]';

    /**
     * @return string
     */
    protected function getRequestType(): string
    {
        return static::MAKE_PAYMENT_PAY_PAL_REQUEST_TYPE;
    }
}
