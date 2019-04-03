<?php

/**
 * MIT License
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerEco\Zed\Adyen\Business\Hook\Mapper\MakePayment;

use Generated\Shared\Transfer\AdyenApiAddressTransfer;
use Generated\Shared\Transfer\AdyenApiAmountTransfer;
use Generated\Shared\Transfer\AdyenApiMakePaymentRequestTransfer;
use Generated\Shared\Transfer\AdyenApiNameTransfer;
use Generated\Shared\Transfer\AdyenApiRequestTransfer;
use Generated\Shared\Transfer\QuoteTransfer;
use SprykerEco\Zed\Adyen\AdyenConfig;

abstract class AbstractMapper implements AdyenMapperInterface
{
    protected const GENDER_MAPPING = ['Mr' => 'MALE', 'Ms' => 'FEMALE', 'Mrs' => 'FEMALE', 'Dr' => 'MALE'];

    /**
     * @var \SprykerEco\Zed\Adyen\AdyenConfig
     */
    protected $config;

    /**
     * @return string
     */
    abstract protected function getReturnUrl(): string;

    /**
     * @param \Generated\Shared\Transfer\QuoteTransfer $quoteTransfer
     *
     * @return string[]
     */
    abstract protected function getPayload(QuoteTransfer $quoteTransfer): array;

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
    public function buildPaymentRequestTransfer(QuoteTransfer $quoteTransfer): AdyenApiRequestTransfer
    {
        $requestTransfer = $this->createRequestTransfer($quoteTransfer);
        $requestTransfer = $this->updateRequestTransfer($quoteTransfer, $requestTransfer);

        return $requestTransfer;
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
            ->setReturnUrl($this->getReturnUrl())
            ->setCountryCode($quoteTransfer->getBillingAddress()->getIso2Code())
            ->setShopperIP($quoteTransfer->getPayment()->getAdyenPayment()->getClientIp());
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
        $requestTransfer = $this->addFraudCheckData($quoteTransfer, $requestTransfer);
        $requestTransfer
            ->getMakePaymentRequest()
            ->setPaymentMethod($this->getPayload($quoteTransfer))
            ->setAdditionalData($this->getAdditionalData());

        return $requestTransfer;
    }

    /**
     * @param \Generated\Shared\Transfer\QuoteTransfer $quoteTransfer
     * @param \Generated\Shared\Transfer\AdyenApiRequestTransfer $requestTransfer
     *
     * @return \Generated\Shared\Transfer\AdyenApiRequestTransfer
     */
    protected function addFraudCheckData(
        QuoteTransfer $quoteTransfer,
        AdyenApiRequestTransfer $requestTransfer
    ): AdyenApiRequestTransfer {
        $requestTransfer
            ->getMakePaymentRequest()
            ->setShopperReference($quoteTransfer->getCustomerReference())
            ->setDateOfBirth($quoteTransfer->getCustomer()->getDateOfBirth())
            ->setShopperName(
                (new AdyenApiNameTransfer())
                    ->setFirstName($quoteTransfer->getBillingAddress()->getFirstName())
                    ->setGender($this->getGender($quoteTransfer))
                    ->setLastName($quoteTransfer->getBillingAddress()->getLastName())
            )
            ->setShopperEmail($quoteTransfer->getCustomer()->getEmail())
            ->setTelephoneNumber($this->getPhoneNumber($quoteTransfer))
            ->setBillingAddress(
                (new AdyenApiAddressTransfer())
                    ->setCity($quoteTransfer->getBillingAddress()->getCity())
                    ->setCountry($quoteTransfer->getBillingAddress()->getIso2Code())
                    ->setHouseNumberOrName($quoteTransfer->getBillingAddress()->getAddress2())
                    ->setPostalCode($quoteTransfer->getBillingAddress()->getZipCode())
                    ->setStreet($quoteTransfer->getBillingAddress()->getAddress1())
            )
            ->setDeliveryAddress(
                (new AdyenApiAddressTransfer())
                    ->setCity($quoteTransfer->getShippingAddress()->getCity())
                    ->setCountry($quoteTransfer->getShippingAddress()->getIso2Code())
                    ->setHouseNumberOrName($quoteTransfer->getShippingAddress()->getAddress2())
                    ->setPostalCode($quoteTransfer->getShippingAddress()->getZipCode())
                    ->setStreet($quoteTransfer->getShippingAddress()->getAddress1())
            );

        return $requestTransfer;
    }

    /**
     * @param \Generated\Shared\Transfer\QuoteTransfer $quoteTransfer
     *
     * @return string|null
     */
    protected function getGender(QuoteTransfer $quoteTransfer): ?string
    {
        if (!array_key_exists($quoteTransfer->getCustomer()->getSalutation(), static::GENDER_MAPPING)) {
            return null;
        }

        return static::GENDER_MAPPING[$quoteTransfer->getCustomer()->getSalutation()];
    }

    /**
     * @param \Generated\Shared\Transfer\QuoteTransfer $quoteTransfer
     *
     * @return string|null
     */
    protected function getPhoneNumber(QuoteTransfer $quoteTransfer): ?string
    {
        return $quoteTransfer->getBillingAddress()->getPhone() ?? $quoteTransfer->getCustomer()->getPhone();
    }

    /**
     * @return string[]
     */
    protected function getAdditionalData(): array
    {
        return [];
    }
}
