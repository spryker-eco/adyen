<?php

/**
 * MIT License
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerEco\Zed\Adyen\Business\Hook;

use Generated\Shared\Transfer\AdyenApiResponseTransfer;
use Generated\Shared\Transfer\AdyenRedirectTransfer;
use Generated\Shared\Transfer\CheckoutErrorTransfer;
use Generated\Shared\Transfer\CheckoutResponseTransfer;
use Generated\Shared\Transfer\QuoteTransfer;
use SprykerEco\Shared\Adyen\AdyenConfig;
use SprykerEco\Zed\Adyen\Business\Hook\Mapper\AdyenMapperResolverInterface;
use SprykerEco\Zed\Adyen\Business\Hook\Saver\AdyenSaverResolverInterface;
use SprykerEco\Zed\Adyen\Dependency\Facade\AdyenToAdyenApiFacadeInterface;

class AdyenPostSaveHook implements AdyenHookInterface
{
    /**
     * @var string
     */
    protected const REDIRECT_METHOD_GET = 'GET';

    /**
     * @var string
     */
    protected const REDIRECT_METHOD_POST = 'POST';

    /**
     * @var string
     */
    protected const ERROR_TYPE_PAYMENT_FAILED = 'payment failed';

    /**
     * @var string
     */
    protected const ERROR_MESSAGE_PAYMENT_FAILED = 'Something went wrong with your payment. Try again!';

    /**
     * @var string
     */
    protected const ADYEN_OMS_STATUS_REFUSED = 'Refused';

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
        $payment = $quoteTransfer->getPaymentOrFail();

        if ($payment->getPaymentProvider() !== AdyenConfig::PROVIDER_NAME) {
            return;
        }

        $paymentSelection = $payment->getPaymentSelectionOrFail();
        $mapper = $this->mapperResolver->resolve($paymentSelection);
        $saver = $this->saverResolver->resolve($paymentSelection);
        $requestTransfer = $mapper->buildPaymentRequestTransfer($quoteTransfer);
        $responseTransfer = $this->adyenApiFacade->performMakePaymentApiCall($requestTransfer);

        $saver->save($requestTransfer, $responseTransfer);

        $makePaymentResponse = $responseTransfer->getMakePaymentResponseOrFail();

        if (
            !$responseTransfer->getIsSuccess() || $makePaymentResponse->getResultCode() === static::ADYEN_OMS_STATUS_REFUSED
        ) {
            $this->processFailureResponse($checkoutResponseTransfer);

            return;
        }

        if (!$this->isMethodWithRedirect($responseTransfer)) {
            return;
        }

        if ($makePaymentResponse->getRedirectOrFail()->getMethod() === static::REDIRECT_METHOD_GET) {
            $this->processGetRedirect($checkoutResponseTransfer, $responseTransfer);

            return;
        }

        if ($makePaymentResponse->getRedirectOrFail()->getMethod() === static::REDIRECT_METHOD_POST) {
            $this->processPostRedirect($checkoutResponseTransfer, $responseTransfer);

            return;
        }
    }

    /**
     * @param \Generated\Shared\Transfer\AdyenApiResponseTransfer $responseTransfer
     *
     * @return bool
     */
    protected function isMethodWithRedirect(AdyenApiResponseTransfer $responseTransfer): bool
    {
        return !empty($responseTransfer->getMakePaymentResponse()->getRedirect());
    }

    /**
     * @param \Generated\Shared\Transfer\CheckoutResponseTransfer $checkoutResponseTransfer
     * @param \Generated\Shared\Transfer\AdyenApiResponseTransfer $responseTransfer
     *
     * @return void
     */
    protected function processGetRedirect(
        CheckoutResponseTransfer $checkoutResponseTransfer,
        AdyenApiResponseTransfer $responseTransfer
    ): void {
        $checkoutResponseTransfer->setIsExternalRedirect(true);
        $checkoutResponseTransfer->setRedirectUrl(
            $responseTransfer->getMakePaymentResponseOrFail()->getRedirectOrFail()->getUrl()
        );
    }

    /**
     * @param \Generated\Shared\Transfer\CheckoutResponseTransfer $checkoutResponseTransfer
     * @param \Generated\Shared\Transfer\AdyenApiResponseTransfer $responseTransfer
     *
     * @return void
     */
    protected function processPostRedirect(
        CheckoutResponseTransfer $checkoutResponseTransfer,
        AdyenApiResponseTransfer $responseTransfer
    ): void {
        $redirect = $responseTransfer->getMakePaymentResponseOrFail()->getRedirectOrFail();

        $redirectTransfer = (new AdyenRedirectTransfer())
            ->setAction($redirect->getUrl())
            ->setFields($redirect->getData());

        $checkoutResponseTransfer->setAdyenRedirect($redirectTransfer);
    }

    /**
     * @param \Generated\Shared\Transfer\CheckoutResponseTransfer $checkoutResponseTransfer
     *
     * @return void
     */
    protected function processFailureResponse(
        CheckoutResponseTransfer $checkoutResponseTransfer
    ): void {
        $error = (new CheckoutErrorTransfer())
            ->setErrorType(static::ERROR_TYPE_PAYMENT_FAILED)
            ->setMessage(static::ERROR_MESSAGE_PAYMENT_FAILED);

        $checkoutResponseTransfer->setIsSuccess(false);
        $checkoutResponseTransfer->addError($error);
    }
}
