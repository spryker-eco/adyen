<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
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
    public function indexAction(Request $request): RedirectResponse
    {
        $responseTransfer = $this->getFactory()->createSofortRedirectHandler()->handle($request);

        if ($responseTransfer->getIsSuccess()) {
            return $this->redirectResponseInternal(CheckoutPageControllerProvider::CHECKOUT_SUCCESS);
        }

        return $this->redirectResponseInternal(CheckoutPageControllerProvider::CHECKOUT_ERROR);
    }
}
