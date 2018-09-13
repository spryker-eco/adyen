<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Yves\Adyen\Controller;


use Spryker\Yves\Kernel\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

/**
 * @method \SprykerEco\Yves\Adyen\AdyenFactory getFactory()
 */
class CallbackController extends AbstractController
{
    public function indexAction(Request $request)
    {
        $response = $request->query->all();
        $response = null;
    }
}
