<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Service\Adyen;

use Generated\Shared\Transfer\QuoteTransfer;
use Spryker\Service\Kernel\AbstractService;

/**
 * @method \SprykerEco\Service\Adyen\AdyenServiceFactory getFactory()
 */
class AdyenService extends AbstractService implements AdyenServiceInterface
{
    /**
     * @param \Generated\Shared\Transfer\QuoteTransfer $quoteTransfer
     *
     * @return string
     */
    public function generateReference(QuoteTransfer $quoteTransfer): string
    {
        return $this
            ->getFactory()
            ->createGenerator()
            ->generateReference($quoteTransfer);
    }
}
