<?php

/**
 * MIT License
 * For full license information, please view the LICENSE file that was distributed with this source code.
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
