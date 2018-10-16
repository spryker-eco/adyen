<?php

/**
 * MIT License
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerEco\Yves\Adyen\Plugin\Payment;

use Generated\Shared\Transfer\PaymentTransfer;
use Generated\Shared\Transfer\QuoteTransfer;
use SprykerEco\Shared\Adyen\AdyenSdkConfig;
use Symfony\Component\HttpFoundation\Request;

class CreditCardPaymentPlugin implements AdyenPaymentPluginInterface
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

        $quoteTransfer
            ->getPayment()
            ->getAdyenCreditCard()
            ->setEncryptedCardNumber($request->get(AdyenSdkConfig::ENCRYPTED_CARD_NUMBER_FIELD))
            ->setEncryptedExpiryMonth($request->get(AdyenSdkConfig::ENCRYPTED_EXPIRY_MONTH_FIELD))
            ->setEncryptedExpiryYear($request->get(AdyenSdkConfig::ENCRYPTED_EXPIRY_YEAR_FIELD))
            ->setEncryptedSecurityCode($request->get(AdyenSdkConfig::ENCRYPTED_SECURITY_CODE_FIELD));
    }
}
