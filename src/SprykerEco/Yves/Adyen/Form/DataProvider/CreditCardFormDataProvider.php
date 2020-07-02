<?php

/**
 * MIT License
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerEco\Yves\Adyen\Form\DataProvider;

use Generated\Shared\Transfer\AdyenApiResponseTransfer;
use Generated\Shared\Transfer\AdyenCreditCardPaymentTransfer;
use Generated\Shared\Transfer\QuoteTransfer;
use Spryker\Shared\Kernel\Transfer\AbstractTransfer;
use SprykerEco\Client\Adyen\AdyenClientInterface;
use SprykerEco\Yves\Adyen\AdyenConfig;
use SprykerEco\Yves\Adyen\Dependency\Client\AdyenToQuoteClientInterface;
use SprykerEco\Yves\Adyen\Form\CreditCardSubForm;

class CreditCardFormDataProvider extends AbstractFormDataProvider
{
    /**
     * @var \SprykerEco\Client\Adyen\AdyenClientInterface
     */
    protected $adyenClient;

    /**
     * @var \SprykerEco\Yves\Adyen\AdyenConfig
     */
    protected $config;

    /**
     * @param \SprykerEco\Yves\Adyen\Dependency\Client\AdyenToQuoteClientInterface $quoteClient
     * @param \SprykerEco\Client\Adyen\AdyenClientInterface $adyenClient
     * @param \SprykerEco\Yves\Adyen\AdyenConfig $config
     */
    public function __construct(
        AdyenToQuoteClientInterface $quoteClient,
        AdyenClientInterface $adyenClient,
        AdyenConfig $config
    ) {
        parent::__construct($quoteClient);

        $this->adyenClient = $adyenClient;
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
        $paymentMethodsRawApiResponse = $this->buildPaymentMethodsRawApiResponse($this->adyenClient->getPaymentMethods($quoteTransfer));

        return [
            CreditCardSubForm::SDK_CHECKOUT_SECURED_FIELDS_URL => $this->config->getSdkCheckoutSecuredFieldsUrl(),
            CreditCardSubForm::SDK_CHECKOUT_ORIGIN_KEY => $this->config->getSdkCheckoutOriginKey(),
            CreditCardSubForm::SDK_CHECKOUT_SHOPPER_JS_URL => $this->config->getSdkCheckoutShopperJsUrl(),
            CreditCardSubForm::SDK_CHECKOUT_SHOPPER_CSS_URL => $this->config->getSdkCheckoutShopperCssUrl(),
            CreditCardSubForm::SDK_CHECKOUT_SHOPPER_JS_INTEGRITY_HASH => $this->config->getSdkCheckoutShopperJsIntegrityHash(),
            CreditCardSubForm::SDK_CHECKOUT_SHOPPER_CSS_INTEGRITY_HASH => $this->config->getSdkCheckoutShopperCssIntegrityHash(),
            CreditCardSubForm::SDK_CHECKOUT_PAYMENT_METHODS => $paymentMethodsRawApiResponse,
        ];
    }

    /**
     * @param \Generated\Shared\Transfer\AdyenApiResponseTransfer $adyenApiResponseTransfer
     *
     * @return string
     */
    protected function buildPaymentMethodsRawApiResponse(AdyenApiResponseTransfer $adyenApiResponseTransfer): string
    {
        $paymentMethodsData = [];

        foreach ($adyenApiResponseTransfer->getPaymentMethods() as $adyenApiPaymentMethodTransfer) {
            $paymentMethodsData[] = $adyenApiPaymentMethodTransfer->toArray();
        }

        return json_encode([AdyenApiResponseTransfer::PAYMENT_METHODS => $paymentMethodsData]);
    }
}
