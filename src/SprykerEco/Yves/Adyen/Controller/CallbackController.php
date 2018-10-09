<?php

/**
 * MIT License
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerEco\Yves\Adyen\Controller;

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
     * @param \Symfony\Component\HttpFoundation\Request $request
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function redirectSofortAction(Request $request): RedirectResponse
    {
        $responseTransfer = $this->getFactory()->createSofortRedirectHandler()->handle($request);

        if ($responseTransfer->getIsSuccess()) {
            return $this->redirectResponseInternal(CheckoutPageControllerProvider::CHECKOUT_SUCCESS);
        }

        return $this->redirectResponseInternal(CheckoutPageControllerProvider::CHECKOUT_ERROR);
    }

    /**
     * @param \Symfony\Component\HttpFoundation\Request $request
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function redirectCreditCard3dAction(Request $request): RedirectResponse
    {
        $responseTransfer = $this->getFactory()->createCreditCard3dRedirectHandler()->handle($request);

        if ($responseTransfer->getIsSuccess()) {
            return $this->redirectResponseInternal(CheckoutPageControllerProvider::CHECKOUT_SUCCESS);
        }

        return $this->redirectResponseInternal(CheckoutPageControllerProvider::CHECKOUT_ERROR);
    }

    /**
     * @param \Symfony\Component\HttpFoundation\Request $request
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function redirectIdealAction(Request $request): RedirectResponse
    {
        $responseTransfer = $this->getFactory()->createIdealRedirectHandler()->handle($request);

        if ($responseTransfer->getIsSuccess()) {
            return $this->redirectResponseInternal(CheckoutPageControllerProvider::CHECKOUT_SUCCESS);
        }

        return $this->redirectResponseInternal(CheckoutPageControllerProvider::CHECKOUT_ERROR);
    }

    /**
     * @param \Symfony\Component\HttpFoundation\Request $request
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function redirectPayPalAction(Request $request): RedirectResponse
    {
        $responseTransfer = $this->getFactory()->createPayPalRedirectHandler()->handle($request);

        if ($responseTransfer->getIsSuccess()) {
            return $this->redirectResponseInternal(CheckoutPageControllerProvider::CHECKOUT_SUCCESS);
        }

        return $this->redirectResponseInternal(CheckoutPageControllerProvider::CHECKOUT_ERROR);
    }
}
