<?php

/**
 * MIT License
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerEco\Zed\Adyen\Business\Hook;

use Generated\Shared\Transfer\AdyenApiResponseTransfer;
use Generated\Shared\Transfer\AdyenRedirectTransfer;
use Generated\Shared\Transfer\CheckoutResponseTransfer;
use Generated\Shared\Transfer\PaymentTransfer;
use Generated\Shared\Transfer\QuoteTransfer;
use SprykerEco\Shared\Adyen\AdyenConfig;
use SprykerEco\Zed\Adyen\Business\Hook\Mapper\AdyenMapperResolverInterface;
use SprykerEco\Zed\Adyen\Business\Hook\Saver\AdyenSaverResolverInterface;
use SprykerEco\Zed\Adyen\Dependency\Facade\AdyenToAdyenApiFacadeInterface;

class AdyenPostSaveHook implements AdyenHookInterface
{
    /**
     * @var \SprykerEco\Zed\Adyen\Dependency\Facade\AdyenToAdyenApiFacadeInterface
     */
    protected $adyenApiFacade;

    /**
     * @var \SprykerEco\Zed\Adyen\Business\Hook\Mapper\AdyenMapperResolverInterface
     */
    protected $mapperResolver;

    /**
     * @var \SprykerEco\Zed\Adyen\Business\Hook\Saver\AdyenSaverResolverInterface
     */
    protected $saverResolver;

    /**
     * @param \SprykerEco\Zed\Adyen\Dependency\Facade\AdyenToAdyenApiFacadeInterface $adyenApiFacade
     * @param \SprykerEco\Zed\Adyen\Business\Hook\Mapper\AdyenMapperResolverInterface $mapperResolver
     * @param \SprykerEco\Zed\Adyen\Business\Hook\Saver\AdyenSaverResolverInterface $saverResolver
     */
    public function __construct(
        AdyenToAdyenApiFacadeInterface $adyenApiFacade,
        AdyenMapperResolverInterface $mapperResolver,
        AdyenSaverResolverInterface $saverResolver
    ) {
        $this->adyenApiFacade = $adyenApiFacade;
        $this->mapperResolver = $mapperResolver;
        $this->saverResolver = $saverResolver;
    }

    /**
     * @param \Generated\Shared\Transfer\QuoteTransfer $quoteTransfer
     * @param \Generated\Shared\Transfer\CheckoutResponseTransfer $checkoutResponseTransfer
     *
     * @return void
     */
    public function execute(QuoteTransfer $quoteTransfer, CheckoutResponseTransfer $checkoutResponseTransfer): void
    {
        if ($quoteTransfer->getPayment()->getPaymentProvider() !== AdyenConfig::PROVIDER_NAME) {
            return;
        }

        $mapper = $this->mapperResolver->resolve($quoteTransfer->getPayment()->getPaymentSelection());
        $saver = $this->saverResolver->resolve($quoteTransfer->getPayment()->getPaymentSelection());

        $requestTransfer = $mapper->buildPaymentRequestTransfer($quoteTransfer);
        $responseTransfer = $this->adyenApiFacade->performMakePaymentApiCall($requestTransfer);
        $saver->save($requestTransfer, $responseTransfer);

        if ($this->isMethodWithRedirect($responseTransfer)) {
            $checkoutResponseTransfer->setIsExternalRedirect(true);
            $checkoutResponseTransfer->setRedirectUrl(
                $responseTransfer->getMakePaymentResponse()->getRedirect()->getUrl()
            );
        }

        if ($quoteTransfer->getPayment()->getPaymentSelection() === PaymentTransfer::ADYEN_CREDIT_CARD) {
            $checkoutResponseTransfer
                ->setAdyenRedirect(
                    (new AdyenRedirectTransfer())
                        ->setAction($responseTransfer->getMakePaymentResponse()->getRedirect()->getUrl())
                        ->setFields($responseTransfer->getMakePaymentResponse()->getRedirect()->getData())
                );
        }
    }

    /**
     * @param \Generated\Shared\Transfer\AdyenApiResponseTransfer $responseTransfer
     *
     * @return bool
     */
    protected function isMethodWithRedirect(AdyenApiResponseTransfer $responseTransfer): bool
    {
        return !empty($responseTransfer->getMakePaymentResponse()->getRedirect())
            && $responseTransfer->getMakePaymentResponse()->getRedirect()->getMethod() === 'GET';
    }
}
