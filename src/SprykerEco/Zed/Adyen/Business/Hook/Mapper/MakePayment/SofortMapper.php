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
use SprykerEco\Shared\Adyen\AdyenSdkConfig;

class SofortMapper extends AbstractMapper implements AdyenMapperInterface
{
    protected const REQUEST_TYPE = 'directEbanking';

    /**
     * @param \Generated\Shared\Transfer\QuoteTransfer $quoteTransfer
     *
     * @return \Generated\Shared\Transfer\AdyenApiRequestTransfer
     */
    public function buildPaymentRequestTransfer(QuoteTransfer $quoteTransfer): AdyenApiRequestTransfer
    {
        $requestTransfer = $this->createRequestTransfer($quoteTransfer);
        $payload = [
            AdyenSdkConfig::REQUEST_TYPE_FIELD => static::REQUEST_TYPE,
        ];

        $requestTransfer
            ->getMakePaymentRequest()
            ->setPaymentMethod($payload);

        return $requestTransfer;
    }
}
