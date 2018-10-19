<?php

/**
 * MIT License
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerEco\Yves\Adyen\Form\DataProvider;

use Generated\Shared\Transfer\AdyenCreditCardPaymentTransfer;
use Generated\Shared\Transfer\QuoteTransfer;
use Spryker\Shared\Kernel\Transfer\AbstractTransfer;
use SprykerEco\Yves\Adyen\AdyenConfig;
use SprykerEco\Yves\Adyen\Dependency\Client\AdyenToQuoteClientInterface;
use SprykerEco\Yves\Adyen\Form\CreditCardSubForm;

class CreditCardFormDataProvider extends AbstractFormDataProvider
{
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

        if ($quoteTransfer->getPayment()->getAdyenCreditCard() === null) {
            $quoteTransfer->getPayment()->setAdyenCreditCard(new AdyenCreditCardPaymentTransfer());
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
            CreditCardSubForm::SDK_CHECKOUT_SECURED_FIELDS_URL => $this->config->getSdkCheckoutSecuredFieldsUrl(),
            CreditCardSubForm::SDK_CHECKOUT_ORIGIN_KEY => $this->config->getSdkCheckoutOriginKey(),
        ];
    }
}
