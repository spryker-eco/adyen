<?php

/**
 * MIT License
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerEco\Zed\Adyen\Business\Hook\Mapper\MakePayment;

use ArrayObject;
use Generated\Shared\Transfer\AdyenApiLineItemTransfer;
use Generated\Shared\Transfer\AdyenApiRequestTransfer;
use Generated\Shared\Transfer\ItemTransfer;
use Generated\Shared\Transfer\QuoteTransfer;
use SprykerEco\Shared\Adyen\AdyenApiRequestConfig;

class KlarnaInvoiceMapper extends AbstractMapper
{
    protected const REQUEST_TYPE = 'klarna';
    protected const KLARNA_TAX_RATE_MULTIPLIER = 100;

    /**
     * @return string
     */
    protected function getReturnUrl(): string
    {
        /** @var \SprykerEco\Zed\Adyen\AdyenConfig $config */
        $config = $this->config;

        return $config->getKlarnaPayReturnUrl();
    }

    /**
     * @param \Generated\Shared\Transfer\QuoteTransfer $quoteTransfer
     *
     * @return array
     */
    protected function getPayload(QuoteTransfer $quoteTransfer): array
    {
        $klarnaRequestTransfer = $quoteTransfer->getPayment()->getAdyenKlarnaInvoiceRequest();
        $payload = [
            AdyenApiRequestConfig::REQUEST_TYPE_FIELD => static::REQUEST_TYPE,
            AdyenApiRequestConfig::BILLING_ADDRESS_FIELD => $klarnaRequestTransfer->getBillingAddress()->modifiedToArray(true, true),
        ];

        if (!$quoteTransfer->getBillingSameAsShipping()) {
            $payload[AdyenApiRequestConfig::DELIVERY_ADDRESS_FIELD] = $klarnaRequestTransfer->getDeliveryAddress()->modifiedToArray(true, true);
        }

        return $payload;
    }

    /**
     * @param \Generated\Shared\Transfer\QuoteTransfer $quoteTransfer
     * @param \Generated\Shared\Transfer\AdyenApiRequestTransfer $requestTransfer
     *
     * @return \Generated\Shared\Transfer\AdyenApiRequestTransfer
     */
    protected function updateRequestTransfer(
        QuoteTransfer $quoteTransfer,
        AdyenApiRequestTransfer $requestTransfer
    ): AdyenApiRequestTransfer {
        $requestTransfer = parent::updateRequestTransfer($quoteTransfer, $requestTransfer);
        $requestTransfer
            ->getMakePaymentRequest()
            ->setLineItems($this->getLineItems($quoteTransfer));

        return $requestTransfer;
    }

    /**
     * @param \Generated\Shared\Transfer\QuoteTransfer $quoteTransfer
     *
     * @return \ArrayObject|\Generated\Shared\Transfer\AdyenApiLineItemTransfer[]
     */
    protected function getLineItems(QuoteTransfer $quoteTransfer): ArrayObject
    {
        $items = array_map(
            function (ItemTransfer $item) {
                return (new AdyenApiLineItemTransfer())
                    ->setId($item->getSku())
                    ->setDescription($item->getName())
                    ->setQuantity($item->getQuantity())
                    ->setTaxAmount($item->getSumTaxAmount())
                    ->setTaxPercentage((int)$item->getTaxRate() * static::KLARNA_TAX_RATE_MULTIPLIER)
                    ->setAmountExcludingTax($item->getSumPrice() - $item->getSumTaxAmount())
                    ->setAmountIncludingTax($item->getSumPrice());
            },
            $quoteTransfer->getItems()->getArrayCopy()
        );

        return new ArrayObject($items);
    }
}
