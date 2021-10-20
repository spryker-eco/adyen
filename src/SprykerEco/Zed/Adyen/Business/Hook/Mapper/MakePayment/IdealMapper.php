<?php

/**
 * MIT License
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerEco\Zed\Adyen\Business\Hook\Mapper\MakePayment;

use Generated\Shared\Transfer\QuoteTransfer;
use SprykerEco\Shared\Adyen\AdyenApiRequestConfig;

class IdealMapper extends AbstractMapper
{
    /**
     * @var string
     */
    protected const REQUEST_TYPE = 'ideal';

    /**
     * @return string
     */
    protected function getReturnUrl(): string
    {
        return $this->config->getIdealReturnUrl();
    }

    /**
     * @param \Generated\Shared\Transfer\QuoteTransfer $quoteTransfer
     *
     * @return array<string, string|null>
     */
    protected function getPayload(QuoteTransfer $quoteTransfer): array
    {
        $idealTransfer = $quoteTransfer->getPaymentOrFail()->getAdyenIdealOrFail();

        return [
            AdyenApiRequestConfig::REQUEST_TYPE_FIELD => static::REQUEST_TYPE,
            AdyenApiRequestConfig::IDEAL_ISSUER_FIELD => $idealTransfer->getIdealIssuer(),
        ];
    }
}
