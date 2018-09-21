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
use Generated\Shared\Transfer\QuoteTransfer;
use Symfony\Component\HttpFoundation\Request;

class KlarnaInvoicePaymentPlugin implements AdyenPaymentPluginInterface
{
    /**
     * @param \Generated\Shared\Transfer\QuoteTransfer $quoteTransfer
     * @param \Symfony\Component\HttpFoundation\Request $request
     *
     * @return void
     */
    public function setPaymentDataToQuote(QuoteTransfer $quoteTransfer, Request $request): void
    {
        $billingAddress = $this->getInvoiceAddress($quoteTransfer->getBillingAddress());
        $shippingAddress = $this->getInvoiceAddress($quoteTransfer->getShippingAddress());
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
     * @param \Generated\Shared\Transfer\AddressTransfer $addressTransfer
     *
     * @return \Generated\Shared\Transfer\AdyenKlarnaAddressTransfer
     */
    protected function getInvoiceAddress(AddressTransfer $addressTransfer): AdyenKlarnaAddressTransfer
    {
        return (new AdyenKlarnaAddressTransfer())
            ->setCountry($addressTransfer->getIso2Code())
            ->setStateOrProvince($addressTransfer->getState())
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
    public function getInvoicePersonalDetails(QuoteTransfer $quoteTransfer): AdyenKlarnaPersonalDetailsTransfer
    {
        return (new AdyenKlarnaPersonalDetailsTransfer())
            ->setFirstName($quoteTransfer->getBillingAddress()->getFirstName())
            ->setInfix($quoteTransfer->getBillingAddress()->getMiddleName())
            ->setLastName($quoteTransfer->getBillingAddress()->getLastName())
            ->setShopperEmail($quoteTransfer->getCustomer()->getEmail())
            ->setTelephoneNumber($quoteTransfer->getBillingAddress()->getPhone())
            ->setDateOfBirth($quoteTransfer->getPayment()->getAdyenKlarnaInvoice()->getDateOfBirth())
            ->setSocialSecurityNumber($quoteTransfer->getPayment()->getAdyenKlarnaInvoice()->getSocialSecurityNumber());
    }
}
