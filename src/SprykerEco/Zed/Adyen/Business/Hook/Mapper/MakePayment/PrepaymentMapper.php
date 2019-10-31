<?php

/**
 * MIT License
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerEco\Zed\Adyen\Business\Hook\Mapper\MakePayment;

use Generated\Shared\Transfer\QuoteTransfer;
use SprykerEco\Shared\Adyen\AdyenApiRequestConfig;

class PrepaymentMapper extends AbstractMapper
{
    /**
     * @return string
     */
    protected function getReturnUrl(): string
    {
        return $this->config->getPrepaymentReturnUrl();
    }

    /**
     * @param \Generated\Shared\Transfer\QuoteTransfer $quoteTransfer
     *
     * @return string[]
     */
    protected function getPayload(QuoteTransfer $quoteTransfer): array
    {
        return [
            AdyenApiRequestConfig::REQUEST_TYPE_FIELD => $this->getPaymentType($quoteTransfer),
        ];
    }

    /**
     * @param \Generated\Shared\Transfer\QuoteTransfer $quoteTransfer
     *
     * @return string
     */
    protected function getPaymentType(QuoteTransfer $quoteTransfer): string
    {
        $countryIsoCode = $quoteTransfer->getBillingAddress()->getIso2Code();
        $bankTransferPaymentMethods = $this->config->getBankTransferPaymentMethods();

        return $bankTransferPaymentMethods[$countryIsoCode] ?? $this->config->getBankTransferDefaultPaymentMethod();
    }
}
