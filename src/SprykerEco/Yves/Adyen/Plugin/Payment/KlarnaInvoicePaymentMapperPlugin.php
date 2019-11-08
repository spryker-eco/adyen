<?php

/**
 * MIT License
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerEco\Yves\Adyen\Plugin\Payment;

use Generated\Shared\Transfer\AddressTransfer;
use Generated\Shared\Transfer\AdyenKlarnaAddressTransfer;
use Generated\Shared\Transfer\AdyenKlarnaInvoiceRequestTransfer;
use Generated\Shared\Transfer\AdyenKlarnaPersonalDetailsTransfer;
use Generated\Shared\Transfer\PaymentTransfer;
use Generated\Shared\Transfer\QuoteTransfer;
use Symfony\Component\HttpFoundation\Request;

class KlarnaInvoicePaymentMapperPlugin implements AdyenPaymentMapperPluginInterface
{
    /**
     * @param \Generated\Shared\Transfer\QuoteTransfer $quoteTransfer
     * @param \Symfony\Component\HttpFoundation\Request $request
     *
     * @return void
     */
    public function setPaymentDataToQuote(QuoteTransfer $quoteTransfer, Request $request): void
    {
        if ($quoteTransfer->getPayment()->getPaymentSelection() !== PaymentTransfer::ADYEN_KLARNA_INVOICE) {
            return;
        }

        $billingAddress = $this->getInvoiceAddress($quoteTransfer->getBillingAddress());
        $shippingAddress = $this->getInvoiceAddress($this->getShippingAddress($quoteTransfer));
        $personalDetails = $this->getInvoicePersonalDetails($quoteTransfer);

        $klarnaInvoiceRequest = (new AdyenKlarnaInvoiceRequestTransfer())
            ->setBillingAddress($billingAddress)
            ->setDeliveryAddress($shippingAddress)
            ->setPersonalDetails($personalDetails);

        $quoteTransfer
            ->getPayment()
            ->setAdyenKlarnaInvoiceRequest($klarnaInvoiceRequest);
    }

    /**
     * @param \Generated\Shared\Transfer\QuoteTransfer $quoteTransfer
     *
     * @return \Generated\Shared\Transfer\AddressTransfer
     */
    protected function getShippingAddress(QuoteTransfer $quoteTransfer): AddressTransfer
    {
        if ($quoteTransfer->getItems()->count() === 0) {
            return $quoteTransfer->getShippingAddress();
        }

        /** @var \Generated\Shared\Transfer\ItemTransfer $itemTransfer */
        $itemTransfer = current($quoteTransfer->getItems());

        if ($itemTransfer->getShipment() !== null && $itemTransfer->getShipment()->getShippingAddress() !== null) {
            return $itemTransfer->getShipment()->getShippingAddress();
        }

        return $quoteTransfer->getShippingAddress();
    }

    /**
     * @param \Generated\Shared\Transfer\AddressTransfer $addressTransfer
     *
     * @return \Generated\Shared\Transfer\AdyenKlarnaAddressTransfer
     */
    protected function getInvoiceAddress(AddressTransfer $addressTransfer): AdyenKlarnaAddressTransfer
    {
        return (new AdyenKlarnaAddressTransfer())
            ->setCountry($addressTransfer->getIso2Code())
            ->setCity($addressTransfer->getCity())
            ->setStreet($addressTransfer->getAddress1())
            ->setHouseNumberOrName($addressTransfer->getAddress2())
            ->setPostalCode($addressTransfer->getZipCode());
    }

    /**
     * @param \Generated\Shared\Transfer\QuoteTransfer $quoteTransfer
     *
     * @return \Generated\Shared\Transfer\AdyenKlarnaPersonalDetailsTransfer
     */
    protected function getInvoicePersonalDetails(QuoteTransfer $quoteTransfer): AdyenKlarnaPersonalDetailsTransfer
    {
        $personalDetailsTransfer = (new AdyenKlarnaPersonalDetailsTransfer())
            ->setFirstName($quoteTransfer->getBillingAddress()->getFirstName())
            ->setLastName($quoteTransfer->getBillingAddress()->getLastName())
            ->setShopperEmail($quoteTransfer->getCustomer()->getEmail())
            ->setTelephoneNumber($quoteTransfer->getBillingAddress()->getPhone())
            ->setSocialSecurityNumber($quoteTransfer->getPayment()->getAdyenKlarnaInvoice()->getSocialSecurityNumber());

        return $personalDetailsTransfer;
    }
}
