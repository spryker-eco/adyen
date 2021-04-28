<?php

/**
 * MIT License
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerEco\Zed\Adyen\Business\Payment\Mapper;

use Generated\Shared\Transfer\AdyenApiAmountTransfer;
use Generated\Shared\Transfer\AdyenApiGetPaymentMethodsRequestTransfer;
use Generated\Shared\Transfer\AdyenApiRequestTransfer;
use Generated\Shared\Transfer\QuoteTransfer;
use SprykerEco\Zed\Adyen\AdyenConfig;

class AdyenPaymentMethodFilterMapper implements AdyenPaymentMethodFilterMapperInterface
{
    /**
     * @var \SprykerEco\Zed\Adyen\AdyenConfig
     */
    protected $config;

    /**
     * @param \SprykerEco\Zed\Adyen\AdyenConfig $config
     */
    public function __construct(AdyenConfig $config)
    {
        $this->config = $config;
    }

    /**
     * @param \Generated\Shared\Transfer\QuoteTransfer $quoteTransfer
     *
     * @return \Generated\Shared\Transfer\AdyenApiRequestTransfer
     */
    public function buildRequestTransfer(QuoteTransfer $quoteTransfer): AdyenApiRequestTransfer
    {
        $requestTransfer = (new AdyenApiRequestTransfer())
            ->setPaymentMethodsRequest($this->createGetPaymentMethodsRequestTransfer($quoteTransfer));

        return $requestTransfer;
    }

    /**
     * @param \Generated\Shared\Transfer\QuoteTransfer $quoteTransfer
     *
     * @return \Generated\Shared\Transfer\AdyenApiGetPaymentMethodsRequestTransfer
     */
    protected function createGetPaymentMethodsRequestTransfer(QuoteTransfer $quoteTransfer): AdyenApiGetPaymentMethodsRequestTransfer
    {
        $countryCode = $quoteTransfer->getBillingAddress() ? $quoteTransfer->getBillingAddress()->getIso2Code() : null;

        return (new AdyenApiGetPaymentMethodsRequestTransfer())
            ->setMerchantAccount($this->config->getMerchantAccount())
            ->setAmount($this->createAmountTransfer($quoteTransfer))
            ->setCountryCode($countryCode)
            ->setChannel($this->config->getRequestChannel());
    }

    /**
     * @param \Generated\Shared\Transfer\QuoteTransfer $quoteTransfer
     *
     * @return \Generated\Shared\Transfer\AdyenApiAmountTransfer
     */
    protected function createAmountTransfer(QuoteTransfer $quoteTransfer): AdyenApiAmountTransfer
    {
        return (new AdyenApiAmountTransfer())
            ->setCurrency($quoteTransfer->getCurrency()->getCode())
            ->setValue($quoteTransfer->getTotals()->getPriceToPay());
    }
}
