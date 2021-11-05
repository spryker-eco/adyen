<?php

/**
 * MIT License
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerEco\Zed\Adyen\Business\Hook\Mapper\MakePayment;

use Generated\Shared\Transfer\QuoteTransfer;
use SprykerEco\Shared\Adyen\AdyenApiRequestConfig;

class CreditCardMapper extends AbstractMapper
{
    /**
     * @var string
     */
    protected const REQUEST_TYPE = 'scheme';

    /**
     * @var array
     */
    protected const THREE_D_SECURE_DATA = ['executeThreeD' => 'true'];

    /**
     * @return string
     */
    protected function getReturnUrl(): string
    {
        return $this->config->isCreditCard3dSecureEnabled() ? $this->config->getCreditCard3DReturnUrl() : '';
    }

    /**
     * @param \Generated\Shared\Transfer\QuoteTransfer $quoteTransfer
     *
     * @return array<string, string|null>
     */
    protected function getPayload(QuoteTransfer $quoteTransfer): array
    {
        $creditCardTransfer = $quoteTransfer->getPaymentOrFail()->getAdyenCreditCardOrFail();

        return [
            AdyenApiRequestConfig::REQUEST_TYPE_FIELD => static::REQUEST_TYPE,
            AdyenApiRequestConfig::ENCRYPTED_CARD_NUMBER_FIELD => $creditCardTransfer->getEncryptedCardNumber(),
            AdyenApiRequestConfig::ENCRYPTED_EXPIRY_MONTH_FIELD => $creditCardTransfer->getEncryptedExpiryMonth(),
            AdyenApiRequestConfig::ENCRYPTED_EXPIRY_YEAR_FIELD => $creditCardTransfer->getEncryptedExpiryYear(),
            AdyenApiRequestConfig::ENCRYPTED_SECURITY_CODE_FIELD => $creditCardTransfer->getEncryptedSecurityCode(),
        ];
    }

    /**
     * @return bool
     */
    protected function is3dSecure(): bool
    {
        return $this->config->isCreditCard3dSecureEnabled();
    }

    /**
     * @return array<string>
     */
    protected function getAdditionalData(): array
    {
        $data = parent::getAdditionalData();
        if ($this->is3dSecure()) {
            $data += static::THREE_D_SECURE_DATA;
        }

        return $data;
    }
}
