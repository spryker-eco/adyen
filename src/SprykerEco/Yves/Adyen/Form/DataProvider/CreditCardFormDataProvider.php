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
use SprykerEco\Yves\Adyen\Dependency\Service\AdyenToUtilEncodingServiceInterface;
use SprykerEco\Yves\Adyen\Form\CreditCardSubForm;

class CreditCardFormDataProvider extends AbstractFormDataProvider
{
    /**
     * @var \SprykerEco\Yves\Adyen\AdyenConfig
     */
    protected $config;

    /**
     * @var \SprykerEco\Client\Adyen\AdyenClientInterface
     */
    protected $adyenClient;

    /**
     * @var \SprykerEco\Yves\Adyen\Dependency\Service\AdyenToUtilEncodingServiceInterface
     */
    protected $utilEncodingService;

    /**
     * @param \SprykerEco\Yves\Adyen\Dependency\Client\AdyenToQuoteClientInterface $quoteClient
     * @param \SprykerEco\Yves\Adyen\AdyenConfig $config
     * @param \SprykerEco\Client\Adyen\AdyenClientInterface $adyenClient
     * @param \SprykerEco\Yves\Adyen\Dependency\Service\AdyenToUtilEncodingServiceInterface $utilEncodingService
     */
    public function __construct(
        AdyenToQuoteClientInterface $quoteClient,
        AdyenConfig $config,
        AdyenClientInterface $adyenClient,
        AdyenToUtilEncodingServiceInterface $utilEncodingService
    ) {
        parent::__construct($quoteClient);

        $this->config = $config;
        $this->adyenClient = $adyenClient;
        $this->utilEncodingService = $utilEncodingService;
    }

    /**
     * @param \Generated\Shared\Transfer\QuoteTransfer $quoteTransfer
     *
     * @return \Generated\Shared\Transfer\QuoteTransfer
     */
    public function getData(AbstractTransfer $quoteTransfer): QuoteTransfer
    {
        $quoteTransfer = $this->updateQuoteWithPaymentData($quoteTransfer);

        if ($quoteTransfer->getPaymentOrFail()->getAdyenCreditCard() === null) {
            $quoteTransfer->getPaymentOrFail()->setAdyenCreditCard(new AdyenCreditCardPaymentTransfer());
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
        $availablePaymentMethodsData = $this->getAvailablePaymentMethodsData($quoteTransfer);

        return [
            CreditCardSubForm::SDK_CHECKOUT_SECURED_FIELDS_URL => $this->config->getSdkCheckoutSecuredFieldsUrl(),
            CreditCardSubForm::SDK_CHECKOUT_ORIGIN_KEY => $this->config->getSdkCheckoutOriginKey(),
            CreditCardSubForm::SDK_CHECKOUT_SHOPPER_JS_URL => $this->config->getSdkCheckoutShopperJsUrl(),
            CreditCardSubForm::SDK_CHECKOUT_SHOPPER_CSS_URL => $this->config->getSdkCheckoutShopperCssUrl(),
            CreditCardSubForm::SDK_CHECKOUT_SHOPPER_JS_INTEGRITY_HASH => $this->config->getSdkCheckoutShopperJsIntegrityHash(),
            CreditCardSubForm::SDK_CHECKOUT_SHOPPER_CSS_INTEGRITY_HASH => $this->config->getSdkCheckoutShopperCssIntegrityHash(),
            CreditCardSubForm::SDK_ENVIRONMENT => $this->config->getSdkEnvironment(),
            CreditCardSubForm::SDK_CHECKOUT_PAYMENT_METHODS => $this->utilEncodingService->encodeJson([AdyenApiResponseTransfer::PAYMENT_METHODS => $availablePaymentMethodsData]),
        ];
    }

    /**
     * @param \Generated\Shared\Transfer\QuoteTransfer $quoteTransfer
     *
     * @return array
     */
    protected function getAvailablePaymentMethodsData(AbstractTransfer $quoteTransfer): array
    {
        $adyenApiResponseTransfer = $this->adyenClient->getPaymentMethods($quoteTransfer);
        $paymentMethodsData = [];

        foreach ($adyenApiResponseTransfer->getPaymentMethods() as $adyenApiPaymentMethodTransfer) {
            $paymentMethodsData[] = $adyenApiPaymentMethodTransfer->toArray();
        }

        return $paymentMethodsData;
    }
}
