<?php

/**
 * MIT License
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerEco\Zed\Adyen\Business\Hook\Mapper\MakePayment;

use Generated\Shared\Transfer\QuoteTransfer;
use SprykerEco\Shared\Adyen\AdyenSdkConfig;

class DirectDebitMapper extends AbstractMapper
{
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
            AdyenSdkConfig::REQUEST_TYPE_FIELD => static::REQUEST_TYPE,
            AdyenSdkConfig::SEPA_OWNER_NAME_FIELD => $directDebitTransfer->getOwnerName(),
            AdyenSdkConfig::SEPA_IBAN_NUMBER_FIELD => $directDebitTransfer->getIbanNumber(),
        ];
    }
}
