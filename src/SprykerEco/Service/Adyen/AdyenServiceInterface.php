<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Service\Adyen;

use Generated\Shared\Transfer\QuoteTransfer;

interface AdyenServiceInterface
{
    /**
     * Specification:
     * - Generate reference (some kind of transaction id) based on QuoteTransfer.
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\QuoteTransfer $quoteTransfer
     *
     * @return string
     */
    public function generateReference(QuoteTransfer $quoteTransfer): string;
}
