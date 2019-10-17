<?php

/**
 * MIT License
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerEco\Zed\Adyen\Business\Hook\Saver\MakePayment;

class KlarnaInvoiceSaver extends AbstractSaver
{
    protected const MAKE_PAYMENT_INVOICE_REQUEST_TYPE = 'MakePayment[KlarnaInvoice]';

    /**
     * @return string
     */
    protected function getRequestType(): string
    {
        return static::MAKE_PAYMENT_INVOICE_REQUEST_TYPE;
    }

    /**
     * @return string
     */
    protected function getPaymentStatus(): string
    {
        return $this->config->getOmsStatusAuthorized();
    }
}
