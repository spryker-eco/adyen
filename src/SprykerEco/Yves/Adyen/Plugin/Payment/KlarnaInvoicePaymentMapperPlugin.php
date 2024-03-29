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
     * {@inheritDoc}
     *  - Sets Klarna payment data to Quote.
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\QuoteTransfer $quoteTransfer
     * @param \Symfony\Component\HttpFoundation\Request $request
     *
     * @return void
     */
    public function setPaymentDataToQuote(QuoteTransfer $quoteTransfer, Request $request): void
    {
        if ($quoteTransfer->getPaymentOrFail()->getPaymentSelection() !== PaymentTransfer::ADYEN_KLARNA_INVOICE) {
            return;
        }

        $billingAddress = $this->getInvoiceAddress($quoteTransfer->getBillingAddressOrFail());
        $shippingAddress = $this->getInvoiceAddress($quoteTransfer->getShippingAddressOrFail());
        $personalDetails = $this->getInvoicePersonalDetails($quoteTransfer);

        $klarnaInvoiceRequest = (new AdyenKlarnaInvoiceRequestTransfer())
            ->setBillingAddress($billingAddress)
            ->setDeliveryAddress($shippingAddress)
            ->setPersonalDetails($personalDetails);

        $quoteTransfer
            ->getPaymentOrFail()
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
            ->setFirstName($quoteTransfer->getBillingAddressOrFail()->getFirstName())
            ->setLastName($quoteTransfer->getBillingAddressOrFail()->getLastName())
            ->setShopperEmail($quoteTransfer->getCustomerOrFail()->getEmail())
            ->setTelephoneNumber($quoteTransfer->getBillingAddressOrFail()->getPhone())
            ->setSocialSecurityNumber($quoteTransfer->getPaymentOrFail()->getAdyenKlarnaInvoiceOrFail()->getSocialSecurityNumber());

        return $personalDetailsTransfer;
    }
}
