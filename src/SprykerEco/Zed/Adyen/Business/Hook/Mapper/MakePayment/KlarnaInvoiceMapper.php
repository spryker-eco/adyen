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
use SprykerEco\Shared\Adyen\AdyenSdkConfig;

class KlarnaInvoiceMapper extends AbstractMapper implements AdyenMapperInterface
{
    protected const REQUEST_TYPE = 'klarna';

    /**
     * @param \Generated\Shared\Transfer\QuoteTransfer $quoteTransfer
     *
     * @return \Generated\Shared\Transfer\AdyenApiRequestTransfer
     */
    public function buildPaymentRequestTransfer(QuoteTransfer $quoteTransfer): AdyenApiRequestTransfer
    {
        $requestTransfer = $this->createRequestTransfer($quoteTransfer);
        $requestTransfer = $this->updateRequestTransfer($requestTransfer, $quoteTransfer);

        return $requestTransfer;
    }

    /**
     * @return string
     */
    protected function getReturnUrl(): string
    {
        return '';
    }

    /**
     * @param \Generated\Shared\Transfer\AdyenApiRequestTransfer $requestTransfer
     * @param \Generated\Shared\Transfer\QuoteTransfer $quoteTransfer
     *
     * @return \Generated\Shared\Transfer\AdyenApiRequestTransfer
     */
    protected function updateRequestTransfer(
        AdyenApiRequestTransfer $requestTransfer,
        QuoteTransfer $quoteTransfer
    ): AdyenApiRequestTransfer {
        $requestTransfer
            ->getMakePaymentRequest()
            ->setCountryCode($quoteTransfer->getBillingAddress()->getIso2Code())
            ->setShopperReference($quoteTransfer->getCustomerReference())
            ->setReturnUrl($this->getReturnUrl())
            ->setLineItems($this->getLineItems($quoteTransfer))
            ->setPaymentMethod($this->getPayload($quoteTransfer));

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
                    ->setTaxPercentage((int)$item->getTaxRate())
                    ->setAmountExcludingTax($item->getSumPrice() - $item->getSumTaxAmount())
                    ->setAmountIncludingTax($item->getSumPrice());
            },
            $quoteTransfer->getItems()->getArrayCopy()
        );

        return new ArrayObject($items);
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
            AdyenSdkConfig::REQUEST_TYPE_FIELD => static::REQUEST_TYPE,
            AdyenSdkConfig::BILLING_ADDRESS_FIELD => $klarnaRequestTransfer->getBillingAddress()->modifiedToArray(true, true),
            AdyenSdkConfig::PERSONAL_DETAILS_FIELD => $klarnaRequestTransfer->getPersonalDetails()->modifiedToArray(true, true),
        ];

        if (!$quoteTransfer->getBillingSameAsShipping()) {
            $payload[AdyenSdkConfig::DELIVERY_ADDRESS_FIELD] = $klarnaRequestTransfer->getDeliveryAddress()->modifiedToArray(true, true);
        }

        return $payload;
    }
}
