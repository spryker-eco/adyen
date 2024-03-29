<?php

/**
 * MIT License
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerEco\Yves\Adyen\Controller;

use Generated\Shared\Transfer\AdyenRedirectResponseTransfer;
use Spryker\Yves\Kernel\Controller\AbstractController;
use SprykerShop\Yves\CheckoutPage\Plugin\Provider\CheckoutPageControllerProvider;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;

/**
 * @method \SprykerEco\Yves\Adyen\AdyenFactory getFactory()
 */
class CallbackController extends AbstractController
{
    /**
     * @var string
     */
    protected const RESULT_CODE_CANCELLED = 'cancelled';

    /**
     * @var string
     */
    protected const RESULT_CODE_REFUSED = 'refused';

    /**
     * @param \Symfony\Component\HttpFoundation\Request $request
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function redirectSofortAction(Request $request): RedirectResponse
    {
        $responseTransfer = $this->getOnlineTransferRedirectResponse($request);

        return $this->handleRedirectFromAdyen($responseTransfer);
    }

    /**
     * @param \Symfony\Component\HttpFoundation\Request $request
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function redirectCreditCard3dAction(Request $request): RedirectResponse
    {
        $responseTransfer = $this->getCreditCard3dRedirectResponse($request);

        return $this->handleRedirectFromAdyen($responseTransfer);
    }

    /**
     * @param \Symfony\Component\HttpFoundation\Request $request
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function redirectIdealAction(Request $request): RedirectResponse
    {
        $responseTransfer = $this->getOnlineTransferRedirectResponse($request);

        return $this->handleRedirectFromAdyen($responseTransfer);
    }

    /**
     * @param \Symfony\Component\HttpFoundation\Request $request
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function redirectPayPalAction(Request $request): RedirectResponse
    {
        $responseTransfer = $this->getOnlineTransferRedirectResponse($request);

        return $this->handleRedirectFromAdyen($responseTransfer);
    }

    /**
     * @param \Symfony\Component\HttpFoundation\Request $request
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function redirectAliPayAction(Request $request): RedirectResponse
    {
        $responseTransfer = $this->getOnlineTransferRedirectResponse($request);

        return $this->handleRedirectFromAdyen($responseTransfer);
    }

    /**
     * @param \Symfony\Component\HttpFoundation\Request $request
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function redirectWeChatPayAction(Request $request): RedirectResponse
    {
        $responseTransfer = $this->getOnlineTransferRedirectResponse($request);

        return $this->handleRedirectFromAdyen($responseTransfer);
    }

    /**
     * @param \Symfony\Component\HttpFoundation\Request $request
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function redirectKlarnaAction(Request $request): RedirectResponse
    {
        $responseTransfer = $this->getOnlineTransferRedirectResponse($request);

        return $this->handleRedirectFromAdyen($responseTransfer);
    }

    /**
     * @param \Symfony\Component\HttpFoundation\Request $request
     *
     * @return \Generated\Shared\Transfer\AdyenRedirectResponseTransfer
     */
    protected function getOnlineTransferRedirectResponse(Request $request): AdyenRedirectResponseTransfer
    {
        return $this->getFactory()->createOnlineTransferRedirectHandler()->handle($request);
    }

    /**
     * @param \Symfony\Component\HttpFoundation\Request $request
     *
     * @return \Generated\Shared\Transfer\AdyenRedirectResponseTransfer
     */
    protected function getCreditCard3dRedirectResponse(Request $request): AdyenRedirectResponseTransfer
    {
        return $this->getFactory()->createCreditCard3dRedirectHandler()->handle($request);
    }

    /**
     * @param \Generated\Shared\Transfer\AdyenRedirectResponseTransfer $responseTransfer
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    protected function handleRedirectFromAdyen(AdyenRedirectResponseTransfer $responseTransfer): RedirectResponse
    {
        if ($responseTransfer->getResultCode() === static::RESULT_CODE_CANCELLED) {
            return $this->redirectResponseInternal(CheckoutPageControllerProvider::CHECKOUT_ERROR);
        }

        if ($responseTransfer->getResultCode() === static::RESULT_CODE_REFUSED) {
            return $this->redirectResponseInternal(CheckoutPageControllerProvider::CHECKOUT_ERROR);
        }

        if ($responseTransfer->getIsSuccess()) {
            return $this->redirectResponseInternal(CheckoutPageControllerProvider::CHECKOUT_SUCCESS);
        }

        return $this->redirectResponseInternal(CheckoutPageControllerProvider::CHECKOUT_ERROR);
    }
}
