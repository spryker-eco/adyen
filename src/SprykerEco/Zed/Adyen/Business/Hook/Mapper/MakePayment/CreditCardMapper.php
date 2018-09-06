<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Zed\Adyen\Business\Hook\Mapper\MakePayment;

use Generated\Shared\Transfer\AdyenApiRequestTransfer;
use Generated\Shared\Transfer\AdyenCreditCardPaymentTransfer;
use Generated\Shared\Transfer\PaymentTransfer;
use Generated\Shared\Transfer\QuoteTransfer;
use SprykerEco\Shared\Adyen\AdyenSdkConstants;

class CreditCardMapper extends AbstractMapper implements AdyenMapperInterface
{
    protected const REQUEST_TYPE = 'scheme';

    /**
     * @return string
     */
    public function getMethodName(): string
    {
        return PaymentTransfer::ADYEN_CREDIT_CARD;
    }

    /**
     * @param \Generated\Shared\Transfer\QuoteTransfer $quoteTransfer
     *
     * @return \Generated\Shared\Transfer\AdyenApiRequestTransfer
     */
    public function buildPaymentRequestTransfer(QuoteTransfer $quoteTransfer): AdyenApiRequestTransfer
    {
        $requestTransfer = $this->createRequestTransfer($quoteTransfer);
        $payload = $this->getPaymentMethodData($quoteTransfer->getPayment()->getAdyenCreditCard());

        $requestTransfer
            ->getMakePaymentRequest()
            ->setPaymentMethod($payload);

        return $requestTransfer;
    }

    /**
     * @param \Generated\Shared\Transfer\AdyenCreditCardPaymentTransfer $creditCardTransfer
     *
     * @return array
     */
    protected function getPaymentMethodData(AdyenCreditCardPaymentTransfer $creditCardTransfer): array
    {
        return [
            AdyenSdkConstants::REQUEST_TYPE_FIELD => static::REQUEST_TYPE,
            AdyenSdkConstants::ENCRYPTED_CARD_NUMBER_FIELD => $creditCardTransfer->getEncryptedCardNumber(),
            AdyenSdkConstants::ENCRYPTED_EXPIRY_MONTH_FIELD => $creditCardTransfer->getEncryptedExpiryMonth(),
            AdyenSdkConstants::ENCRYPTED_EXPIRY_YEAR_FIELD => $creditCardTransfer->getEncryptedExpiryYear(),
            AdyenSdkConstants::ENCRYPTED_SECURITY_CODE_FIELD => $creditCardTransfer->getEncryptedSecurityCode(),
        ];
    }
}
