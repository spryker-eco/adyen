<?php

/**
 * MIT License
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerEco\Zed\Adyen\Dependency\Service;

use Generated\Shared\Transfer\QuoteTransfer;

interface AdyenToUtilQuantityServiceInterface
{
    /**
     * @param \Generated\Shared\Transfer\QuoteTransfer $quoteTransfer
     *
     * @return bool
     */
    public function isQuoteInt(QuoteTransfer $quoteTransfer): bool;

    /**
     * @param $quantity
     *
     * @return int
     */
    public function toInt($quantity): int;
}
