<?php

/**
 * MIT License
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerEco\Yves\Adyen\Form\DataProvider;

use Generated\Shared\Transfer\AdyenKlarnaInvoicePaymentTransfer;
use Generated\Shared\Transfer\QuoteTransfer;
use Spryker\Shared\Kernel\Transfer\AbstractTransfer;
use SprykerEco\Yves\Adyen\AdyenConfig;
use SprykerEco\Yves\Adyen\Dependency\Client\AdyenToQuoteClientInterface;

class KlarnaInvoiceFormDataProvider extends AbstractFormDataProvider
{
    /**
     * @var string
     */
    public const SOCIAL_SECURITY_NUMBER_REQUIRED = 'SOCIAL_SECURITY_NUMBER_REQUIRED';

    /**
     * @var \SprykerEco\Yves\Adyen\AdyenConfig
     */
    protected $config;

    /**
     * @param \SprykerEco\Yves\Adyen\Dependency\Client\AdyenToQuoteClientInterface $quoteClient
     * @param \SprykerEco\Yves\Adyen\AdyenConfig $config
     */
    public function __construct(
        AdyenToQuoteClientInterface $quoteClient,
        AdyenConfig $config
    ) {
        parent::__construct($quoteClient);

        $this->config = $config;
    }

    /**
     * @param \Generated\Shared\Transfer\QuoteTransfer $quoteTransfer
     *
     * @return \Generated\Shared\Transfer\QuoteTransfer
     */
    public function getData(AbstractTransfer $quoteTransfer): QuoteTransfer
    {
        $quoteTransfer = $this->updateQuoteWithPaymentData($quoteTransfer);

        if ($quoteTransfer->getPaymentOrFail()->getAdyenKlarnaInvoice() === null) {
            $quoteTransfer->getPaymentOrFail()->setAdyenKlarnaInvoice(new AdyenKlarnaInvoicePaymentTransfer());
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
            static::SOCIAL_SECURITY_NUMBER_REQUIRED => $this->isSocialSecurityNumberRequired($quoteTransfer),
        ];
    }

    /**
     * @param \Generated\Shared\Transfer\QuoteTransfer $quoteTransfer
     *
     * @return bool
     */
    protected function isSocialSecurityNumberRequired(QuoteTransfer $quoteTransfer): bool
    {
        return in_array(
            $quoteTransfer->getBillingAddressOrFail()->getIso2Code(),
            $this->config->getSocialSecurityNumberCountriesMandatory()
        );
    }
}
