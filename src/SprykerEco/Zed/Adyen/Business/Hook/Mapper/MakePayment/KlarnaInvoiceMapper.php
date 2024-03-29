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

/**
 * @property \SprykerEco\Zed\Adyen\AdyenConfig $config
 */
class KlarnaInvoiceMapper extends AbstractMapper
{
    /**
     * @var string
     */
    protected const REQUEST_TYPE = 'klarna';

    /**
     * @return string
     */
    protected function getReturnUrl(): string
    {
        return $this->config->getKlarnaPayReturnUrl();
    }

    /**
     * @param \Generated\Shared\Transfer\QuoteTransfer $quoteTransfer
     *
     * @return array
     */
    protected function getPayload(QuoteTransfer $quoteTransfer): array
    {
        $klarnaRequestTransfer = $quoteTransfer->getPaymentOrFail()->getAdyenKlarnaInvoiceRequestOrFail();
        $payload = [
            AdyenApiRequestConfig::REQUEST_TYPE_FIELD => static::REQUEST_TYPE,
            AdyenApiRequestConfig::BILLING_ADDRESS_FIELD => $klarnaRequestTransfer->getBillingAddressOrFail()->modifiedToArray(true, true),
        ];

        if (!$quoteTransfer->getBillingSameAsShipping()) {
            $payload[AdyenApiRequestConfig::DELIVERY_ADDRESS_FIELD] = $klarnaRequestTransfer->getDeliveryAddressOrFail()->modifiedToArray(true, true);
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

        $requestTransfer->getMakePaymentRequestOrFail()
            ->setLineItems($this->getLineItems($quoteTransfer));

        return $requestTransfer;
    }

    /**
     * @phpstan-return \ArrayObject<int, \Generated\Shared\Transfer\AdyenApiLineItemTransfer&static>
     *
     * @param \Generated\Shared\Transfer\QuoteTransfer $quoteTransfer
     *
     * @return \ArrayObject<int, \Generated\Shared\Transfer\AdyenApiLineItemTransfer>
     */
    protected function getLineItems(QuoteTransfer $quoteTransfer): ArrayObject
    {
        $taxMultiplier = $this->config->getKlarnaTaxRateMultiplier();

        $items = array_map(
            function (ItemTransfer $item) use ($taxMultiplier) {
                return (new AdyenApiLineItemTransfer())
                    ->setId($item->getSku())
                    ->setDescription($item->getName())
                    ->setQuantity($item->getQuantity())
                    ->setTaxAmount($item->getSumTaxAmount())
                    ->setTaxPercentage((int)$item->getTaxRate() * $taxMultiplier)
                    ->setAmountExcludingTax($item->getSumPrice() - $item->getSumTaxAmount())
                    ->setAmountIncludingTax($item->getSumPrice());
            },
            $quoteTransfer->getItems()->getArrayCopy(),
        );

        return new ArrayObject(array_values($items));
    }
}
