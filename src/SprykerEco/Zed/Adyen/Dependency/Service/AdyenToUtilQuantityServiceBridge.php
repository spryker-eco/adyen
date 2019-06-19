<?php

/**
 * MIT License
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerEco\Zed\Adyen\Dependency\Service;

use Generated\Shared\Transfer\QuoteTransfer;

class AdyenToUtilQuantityServiceBridge implements AdyenToUtilQuantityServiceInterface
{
    /**
     * @var \Spryker\Service\UtilQuantity\UtilQuantityServiceInterface
     */
    protected $utilQuantityService;

    /**
     * @param \Spryker\Service\UtilQuantity\UtilQuantityServiceInterface $utilQuantityService
     */
    public function __construct($utilQuantityService)
    {
        $this->utilQuantityService = $utilQuantityService;
    }

    /**
     * @param \Generated\Shared\Transfer\QuoteTransfer $quoteTransfer
     *
     * @return bool
     */
    public function isQuoteInt(QuoteTransfer $quoteTransfer): bool
    {
        return $this->utilQuantityService->isQuoteInt($quoteTransfer);
    }

    /**
     * @param $quantity
     *
     * @return int
     */
    public function toInt($quantity): int
    {
        return $this->utilQuantityService->toInt($quantity);
    }
}
