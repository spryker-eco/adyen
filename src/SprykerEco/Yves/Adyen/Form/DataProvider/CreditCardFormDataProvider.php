<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Yves\Adyen\Form\DataProvider;

use Generated\Shared\Transfer\AdyenCreditCardPaymentTransfer;
use Generated\Shared\Transfer\AdyenPaymentTransfer;
use Generated\Shared\Transfer\PaymentTransfer;
use Generated\Shared\Transfer\QuoteTransfer;
use Spryker\Shared\Kernel\Transfer\AbstractTransfer;

class CreditCardFormDataProvider extends AbstractFormDataProvider
{
    /**
     * @param \Spryker\Shared\Kernel\Transfer\AbstractTransfer|\Generated\Shared\Transfer\QuoteTransfer $quoteTransfer
     *
     * @return \Generated\Shared\Transfer\QuoteTransfer
     */
    public function getData(AbstractTransfer $quoteTransfer): QuoteTransfer
    {
        if ($quoteTransfer->getPayment() === null) {
            $paymentTransfer = new PaymentTransfer();
            $quoteTransfer->setPayment($paymentTransfer);
        }

        $paymentTransfer = $quoteTransfer->getPayment();

        if ($paymentTransfer->getAdyenPayment() === null) {
            $paymentTransfer->setAdyenPayment(new AdyenPaymentTransfer());
        }

        if ($paymentTransfer->getAdyenCreditCard() === null) {
            $paymentTransfer->setAdyenCreditCard(new AdyenCreditCardPaymentTransfer());
        }

        $this->quoteClient->setQuote($quoteTransfer);

        return $quoteTransfer;
    }
}
