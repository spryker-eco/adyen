<?php

/**
 * MIT License
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerEco\Zed\Adyen\Business\Hook\Mapper\MakePayment;

use Generated\Shared\Transfer\QuoteTransfer;
use SprykerEco\Shared\Adyen\AdyenApiRequestConfig;

class DirectDebitMapper extends AbstractMapper
{
    /**
     * @var string
     */
    protected const REQUEST_TYPE = 'sepadirectdebit';

    /**
     * @return string
     */
    protected function getReturnUrl(): string
    {
        return '';
    }

    /**
     * @param \Generated\Shared\Transfer\QuoteTransfer $quoteTransfer
     *
     * @return string[]
     */
    protected function getPayload(QuoteTransfer $quoteTransfer): array
    {
        $directDebitTransfer = $quoteTransfer->getPayment()->getAdyenDirectDebit();

        return [
            AdyenApiRequestConfig::REQUEST_TYPE_FIELD => static::REQUEST_TYPE,
            AdyenApiRequestConfig::SEPA_OWNER_NAME_FIELD => $directDebitTransfer->getOwnerName(),
            AdyenApiRequestConfig::SEPA_IBAN_NUMBER_FIELD => $directDebitTransfer->getIbanNumber(),
        ];
    }
}
