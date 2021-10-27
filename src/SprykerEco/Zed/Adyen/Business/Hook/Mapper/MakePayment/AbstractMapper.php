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
use Spryker\Shared\Kernel\Transfer\Exception\NullValueException;
use SprykerEco\Zed\Adyen\AdyenConfig;

abstract class AbstractMapper implements AdyenMapperInterface
{
    /**
     * @var array<string, string>
     */
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
        $payment = $quoteTransfer->getPaymentOrFail();
        $adyenPayment = $payment->getAdyenPaymentOrFail();
        $billingAddress = $quoteTransfer->getBillingAddressOrFail();

        return (new AdyenApiMakePaymentRequestTransfer())
            ->setMerchantAccount($this->config->getMerchantAccount())
            ->setReference($adyenPayment->getReference())
            ->setAmount($this->createAmountTransfer($quoteTransfer))
            ->setReturnUrl($this->getReturnUrl())
            ->setCountryCode($billingAddress->getIso2Code())
            ->setShopperIP($adyenPayment->getClientIp());
    }

    /**
     * @param \Generated\Shared\Transfer\QuoteTransfer $quoteTransfer
     *
     * @return \Generated\Shared\Transfer\AdyenApiAmountTransfer
     */
    protected function createAmountTransfer(QuoteTransfer $quoteTransfer): AdyenApiAmountTransfer
    {
        return (new AdyenApiAmountTransfer())
            ->setCurrency($quoteTransfer->getCurrencyOrFail()->getCode())
            ->setValue($quoteTransfer->getTotalsOrFail()->getPriceToPay());
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
            ->getMakePaymentRequestOrFail()
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
        $customer = $quoteTransfer->getCustomerOrFail();
        $billingAddress = $quoteTransfer->getBillingAddressOrFail();
        $shippingAddress = $quoteTransfer->getShippingAddressOrFail();

        $requestTransfer
            ->getMakePaymentRequestOrFail()
            ->setShopperReference($quoteTransfer->getCustomerReference())
            ->setDateOfBirth($customer->getDateOfBirth())
            ->setShopperName(
                (new AdyenApiNameTransfer())
                    ->setFirstName($billingAddress->getFirstName())
                    ->setGender($this->getGender($quoteTransfer))
                    ->setLastName($billingAddress->getLastName()),
            )
            ->setShopperEmail($customer->getEmail())
            ->setTelephoneNumber($this->getPhoneNumber($quoteTransfer))
            ->setBillingAddress(
                (new AdyenApiAddressTransfer())
                    ->setCity($billingAddress->getCity())
                    ->setCountry($billingAddress->getIso2Code())
                    ->setHouseNumberOrName($billingAddress->getAddress2())
                    ->setPostalCode($billingAddress->getZipCode())
                    ->setStreet($billingAddress->getAddress1()),
            )
            ->setDeliveryAddress(
                (new AdyenApiAddressTransfer())
                    ->setCity($shippingAddress->getCity())
                    ->setCountry($shippingAddress->getIso2Code())
                    ->setHouseNumberOrName($shippingAddress->getAddress2())
                    ->setPostalCode($shippingAddress->getZipCode())
                    ->setStreet($shippingAddress->getAddress1()),
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
        $customer = $quoteTransfer->getCustomerOrFail();

        if ($customer->getSalutation() !== null && !array_key_exists($customer->getSalutation(), static::GENDER_MAPPING)) {
            return null;
        }

        return static::GENDER_MAPPING[$customer->getSalutation()];
    }

    /**
     * @param \Generated\Shared\Transfer\QuoteTransfer $quoteTransfer
     *
     * @return string|null
     */
    protected function getPhoneNumber(QuoteTransfer $quoteTransfer): ?string
    {
        return $this->getPhoneNumberByBillingAddress($quoteTransfer) ?? $this->getPhoneNumberByCustomer($quoteTransfer);
    }

    /**
     * @param \Generated\Shared\Transfer\QuoteTransfer $quoteTransfer
     *
     * @return string|null
     */
    protected function getPhoneNumberByBillingAddress(QuoteTransfer $quoteTransfer): ?string
    {
        try {
            return $quoteTransfer->getBillingAddressOrFail()->getPhoneOrFail();
        } catch (NullValueException $e) {
            return null;
        }
    }

    /**
     * @param \Generated\Shared\Transfer\QuoteTransfer $quoteTransfer
     *
     * @return string|null
     */
    protected function getPhoneNumberByCustomer(QuoteTransfer $quoteTransfer): ?string
    {
        try {
            return $quoteTransfer->getCustomerOrFail()->getPhoneOrFail();
        } catch (NullValueException $e) {
            return null;
        }
    }

    /**
     * @return string[]
     */
    protected function getAdditionalData(): array
    {
        return [];
    }
}
