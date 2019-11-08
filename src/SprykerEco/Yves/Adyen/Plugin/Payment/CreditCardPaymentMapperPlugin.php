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
     * @param \Generated\Shared\Transfer\QuoteTransfer $quoteTransfer
     * @param \Symfony\Component\HttpFoundation\Request $request
     *
     * @return void
     */
    public function setPaymentDataToQuote(QuoteTransfer $quoteTransfer, Request $request): void
    {
        if ($quoteTransfer->getPayment()->getPaymentSelection() !== PaymentTransfer::ADYEN_CREDIT_CARD) {
            return;
        }

        $encryptedCardNumber = $request->get(AdyenApiRequestConfig::ENCRYPTED_CARD_NUMBER_FIELD);
        $encryptedExpiryMonth = $request->get(AdyenApiRequestConfig::ENCRYPTED_EXPIRY_MONTH_FIELD);
        $encryptedExpiryYear = $request->get(AdyenApiRequestConfig::ENCRYPTED_EXPIRY_YEAR_FIELD);
        $encryptedSecurityCode = $request->get(AdyenApiRequestConfig::ENCRYPTED_SECURITY_CODE_FIELD);

        if ($encryptedCardNumber === null && $encryptedExpiryMonth === null
            && $encryptedExpiryYear === null && $encryptedSecurityCode === null) {
            return;
        }

        $adyenCreditCardPaymentTransfer = $quoteTransfer
            ->getPayment()
            ->getAdyenCreditCard();

        $adyenCreditCardPaymentTransfer
            ->setEncryptedCardNumber($encryptedCardNumber)
            ->setEncryptedExpiryMonth($encryptedExpiryMonth)
            ->setEncryptedExpiryYear($encryptedExpiryYear)
            ->setEncryptedSecurityCode($encryptedSecurityCode ?? $adyenCreditCardPaymentTransfer->getEncryptedSecurityCode());
    }
}
