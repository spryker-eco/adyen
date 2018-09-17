<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Client\Adyen;

use Generated\Shared\Transfer\AdyenRedirectResponseTransfer;
use Spryker\Client\Kernel\AbstractClient;

/**
 * @method \SprykerEco\Client\Adyen\AdyenFactory getFactory()
 */
class AdyenClient extends AbstractClient implements AdyenClientInterface
{
    /**
     * {@inheritdoc}
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\AdyenRedirectResponseTransfer $redirectResponseTransfer
     *
     * @return \Generated\Shared\Transfer\AdyenRedirectResponseTransfer
     */
    public function handleSofortResponseFromAdyen(AdyenRedirectResponseTransfer $redirectResponseTransfer): AdyenRedirectResponseTransfer
    {
        return $this
            ->getFactory()
            ->createZedStub()
            ->handleSofortResponseFromAdyen($redirectResponseTransfer);
    }
}
