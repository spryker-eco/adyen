<?php

/**
 * MIT License
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerEco\Zed\Adyen\Business\Hook\Mapper\MakePayment;

use Generated\Shared\Transfer\AdyenApiRequestTransfer;
use Generated\Shared\Transfer\QuoteTransfer;
use SprykerEco\Shared\Adyen\AdyenSdkConfig;

class IdealMapper extends AbstractMapper implements AdyenMapperInterface
{
    protected const REQUEST_TYPE = 'ideal';

    /**
     * @param \Generated\Shared\Transfer\QuoteTransfer $quoteTransfer
     *
     * @return \Generated\Shared\Transfer\AdyenApiRequestTransfer
     */
    public function buildPaymentRequestTransfer(QuoteTransfer $quoteTransfer): AdyenApiRequestTransfer
    {
        $requestTransfer = $this->createRequestTransfer($quoteTransfer);
        $requestTransfer
            ->getMakePaymentRequest()
            ->setPaymentMethod($this->getPayload($quoteTransfer));

        return $requestTransfer;
    }

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
     * @return string[]
     */
    protected function getPayload(QuoteTransfer $quoteTransfer): array
    {
        return [
            AdyenSdkConfig::REQUEST_TYPE_FIELD => static::REQUEST_TYPE,
            AdyenSdkConfig::IDEAL_ISSUER_FIELD => $quoteTransfer->getPayment()->getAdyenIdeal()->getIdealIssuer(),
        ];
    }
}
