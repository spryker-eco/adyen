<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Zed\Adyen\Business\Hook\Mapper\MakePayment;

use Generated\Shared\Transfer\AdyenApiAmountTransfer;
use Generated\Shared\Transfer\AdyenApiMakePaymentRequestTransfer;
use Generated\Shared\Transfer\AdyenApiRequestTransfer;
use Generated\Shared\Transfer\QuoteTransfer;
use SprykerEco\Zed\Adyen\AdyenConfig;

abstract class AbstractMapper
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
    protected function createRequestTransfer(QuoteTransfer $quoteTransfer): AdyenApiRequestTransfer
    {
        return (new AdyenApiRequestTransfer())
            ->setMakePaymentRequest($this->createMakePaymentRequestTransfer($quoteTransfer));
    }

    /**
     * @param \Generated\Shared\Transfer\QuoteTransfer $quoteTransfer
     *
     * @return \Generated\Shared\Transfer\AdyenApiMakePaymentRequestTransfer
     */
    protected function createMakePaymentRequestTransfer(QuoteTransfer $quoteTransfer): AdyenApiMakePaymentRequestTransfer
    {
        return (new AdyenApiMakePaymentRequestTransfer())
            ->setMerchantAccount($this->config->getMerchantAccount())
            ->setReference($quoteTransfer->getPayment()->getAdyenPayment()->getReference())
            ->setAmount($this->createAmountTransfer($quoteTransfer))
            ->setReturnUrl($this->config->getReturnUrl());
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
