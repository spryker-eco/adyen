<?php

/**
 * MIT License
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerEco\Service\Adyen\Dependency\Service;

class AdyenToUtilTextServiceBridge implements AdyenToUtilTextServiceInterface
{
    /**
     * @var \Spryker\Service\UtilText\UtilTextServiceInterface
     */
    protected $textService;

    /**
     * @param \Spryker\Service\UtilText\UtilTextServiceInterface $textService
     */
    public function __construct($textService)
    {
        $this->textService = $textService;
    }

    /**
     * @param string $algorithm
     * @param mixed $value
     *
     * @return string
     */
    public function hashValue($algorithm, $value): string
    {
        return $this->textService->hashValue($algorithm, $value);
    }
}