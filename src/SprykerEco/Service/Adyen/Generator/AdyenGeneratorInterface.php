<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Service\Adyen\Generator;

use Generated\Shared\Transfer\QuoteTransfer;

interface AdyenGeneratorInterface
{
    /**
     * @param \Generated\Shared\Transfer\QuoteTransfer $quoteTransfer
     *
     * @return string
     */
    public function generateReference(QuoteTransfer $quoteTransfer): string;
}
