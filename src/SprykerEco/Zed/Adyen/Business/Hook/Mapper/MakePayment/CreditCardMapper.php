<?php

/**
 * MIT License
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerEco\Zed\Adyen\Business\Hook\Mapper\MakePayment;

use Generated\Shared\Transfer\AdyenApiRequestTransfer;
use Generated\Shared\Transfer\AdyenCreditCardPaymentTransfer;
use Generated\Shared\Transfer\QuoteTransfer;
use SprykerEco\Shared\Adyen\AdyenSdkConfig;

class CreditCardMapper extends AbstractMapper implements AdyenMapperInterface
{
    protected const REQUEST_TYPE = 'scheme';

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
     * @return string[]
     */
    protected function getPaymentMethodData(AdyenCreditCardPaymentTransfer $creditCardTransfer): array
    {
        return [
            AdyenSdkConfig::REQUEST_TYPE_FIELD => static::REQUEST_TYPE,
            AdyenSdkConfig::ENCRYPTED_CARD_NUMBER_FIELD => $creditCardTransfer->getEncryptedCardNumber(),
            AdyenSdkConfig::ENCRYPTED_EXPIRY_MONTH_FIELD => $creditCardTransfer->getEncryptedExpiryMonth(),
            AdyenSdkConfig::ENCRYPTED_EXPIRY_YEAR_FIELD => $creditCardTransfer->getEncryptedExpiryYear(),
            AdyenSdkConfig::ENCRYPTED_SECURITY_CODE_FIELD => $creditCardTransfer->getEncryptedSecurityCode(),
        ];
    }
}
