<?php

/**
 * MIT License
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerEco\Yves\Adyen\Form\DataProvider;

use Generated\Shared\Transfer\AdyenKlarnaInvoicePaymentTransfer;
use Generated\Shared\Transfer\AdyenPaymentTransfer;
use Generated\Shared\Transfer\PaymentTransfer;
use Generated\Shared\Transfer\QuoteTransfer;
use Spryker\Shared\Kernel\Transfer\AbstractTransfer;
use SprykerEco\Yves\Adyen\AdyenConfig;
use SprykerEco\Yves\Adyen\Dependency\Client\AdyenToQuoteClientInterface;
use SprykerEco\Yves\Adyen\Dependency\Client\AdyenToStoreClientInterface;

class KlarnaInvoiceFormDataProvider extends AbstractFormDataProvider
{
    public const SOCIAL_SECURITY_NUMBER_REQUIRED = 'SOCIAL_SECURITY_NUMBER_REQUIRED';

    /**
     * @var \SprykerEco\Yves\Adyen\Dependency\Client\AdyenToStoreClientInterface
     */
    protected $storeClient;

    /**
     * @var \SprykerEco\Yves\Adyen\AdyenConfig
     */
    protected $config;

    /**
     * @param \SprykerEco\Yves\Adyen\Dependency\Client\AdyenToQuoteClientInterface $quoteClient
     * @param \SprykerEco\Yves\Adyen\Dependency\Client\AdyenToStoreClientInterface $storeClient
     * @param \SprykerEco\Yves\Adyen\AdyenConfig $config
     */
    public function __construct(
        AdyenToQuoteClientInterface $quoteClient,
        AdyenToStoreClientInterface $storeClient,
        AdyenConfig $config
    ) {
        parent::__construct($quoteClient);

        $this->storeClient = $storeClient;
        $this->config = $config;
    }

    /**
     * @param \Generated\Shared\Transfer\QuoteTransfer $quoteTransfer
     *
     * @return \Generated\Shared\Transfer\QuoteTransfer
     */
    public function getData(AbstractTransfer $quoteTransfer): QuoteTransfer
    {
        if ($quoteTransfer->getPayment() === null) {
            $paymentTransfer = new PaymentTransfer();
            $quoteTransfer->setPayment($paymentTransfer);
        }

        $paymentTransfer = $quoteTransfer->getPayment();

        if ($paymentTransfer->getAdyenPayment() === null) {
            $paymentTransfer->setAdyenPayment(new AdyenPaymentTransfer());
        }

        if ($paymentTransfer->getAdyenKlarnaInvoice() === null) {
            $paymentTransfer->setAdyenKlarnaInvoice(new AdyenKlarnaInvoicePaymentTransfer());
        }

        $this->quoteClient->setQuote($quoteTransfer);

        return $quoteTransfer;
    }

    /**
     * @param \Generated\Shared\Transfer\QuoteTransfer $quoteTransfer
     *
     * @return array
     */
    public function getOptions(AbstractTransfer $quoteTransfer): array
    {
        return [
            static::SOCIAL_SECURITY_NUMBER_REQUIRED => $this->isSocialSecurityNumberRequired(),
        ];
    }

    /**
     * @return bool
     */
    protected function isSocialSecurityNumberRequired(): bool
    {
        $storeTransfer = $this->storeClient->getCurrentStore();

        return in_array(
            $storeTransfer->getDefaultCurrencyIsoCode(),
            $this->config->getSocialSecurityNumberCountriesMandatory()
        );
    }
}
