<?php

/**
 * MIT License
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerEco\Yves\Adyen\Plugin\Payment;

use Generated\Shared\Transfer\PaymentTransfer;
use Generated\Shared\Transfer\QuoteTransfer;
use SprykerEco\Shared\Adyen\AdyenApiRequestConfig;
use Symfony\Component\HttpFoundation\Request;

class CreditCardPaymentMapperPlugin implements AdyenPaymentMapperPluginInterface
{
    /**
     * {@inheritDoc}
     *  - Sets `CreditCard` payment data to `Quote`.
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\QuoteTransfer $quoteTransfer
     * @param \Symfony\Component\HttpFoundation\Request $request
     *
     * @return void
     */
    public function setPaymentDataToQuote(QuoteTransfer $quoteTransfer, Request $request): void
    {
        $payment = $quoteTransfer->getPaymentOrFail();

        if ($payment->getPaymentSelection() !== PaymentTransfer::ADYEN_CREDIT_CARD) {
            return;
        }

        $payment->getAdyenCreditCardOrFail()
            ->setEncryptedCardNumber($request->get(AdyenApiRequestConfig::ENCRYPTED_CARD_NUMBER_FIELD))
            ->setEncryptedExpiryMonth($request->get(AdyenApiRequestConfig::ENCRYPTED_EXPIRY_MONTH_FIELD))
            ->setEncryptedExpiryYear($request->get(AdyenApiRequestConfig::ENCRYPTED_EXPIRY_YEAR_FIELD))
            ->setEncryptedSecurityCode($request->get(AdyenApiRequestConfig::ENCRYPTED_SECURITY_CODE_FIELD));
    }
}
