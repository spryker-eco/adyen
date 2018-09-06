<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Zed\Adyen\Business\Hook;

use Generated\Shared\Transfer\CheckoutResponseTransfer;
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
    }
}
