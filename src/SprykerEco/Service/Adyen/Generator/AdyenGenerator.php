<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Service\Adyen\Generator;

use Generated\Shared\Transfer\QuoteTransfer;
use Spryker\Service\UtilText\Model\Hash;
use SprykerEco\Service\Adyen\Dependency\Service\AdyenToUtilTextServiceInterface;

class AdyenGenerator implements AdyenGeneratorInterface
{
    protected const PARAMETERS_SEPARATOR = '-';
    protected const REFERENCE_LENGTH = 80;

    /**
     * @var \SprykerEco\Service\Adyen\Dependency\Service\AdyenToUtilTextServiceInterface
     */
    protected $textService;

    /**
     * @param \SprykerEco\Service\Adyen\Dependency\Service\AdyenToUtilTextServiceInterface $textService
     */
    public function __construct(AdyenToUtilTextServiceInterface $textService)
    {
        $this->textService = $textService;
    }

    /**
     * @param \Generated\Shared\Transfer\QuoteTransfer $quoteTransfer
     *
     * @return string
     */
    public function generateReference(QuoteTransfer $quoteTransfer): string
    {
        $parameters = [
            $this->createUniqueSalt(),
            $quoteTransfer->getTotals()->getHash(),
        ];

        $string = $this->textService->hashValue(implode(static::PARAMETERS_SEPARATOR, $parameters), Hash::SHA256);

        return substr($string, 0, static::REFERENCE_LENGTH);
    }

    /**
     * @return string
     */
    protected function createUniqueSalt(): string
    {
        $params = [
            time(),
            rand(100, 1000),
        ];

        return implode(static::PARAMETERS_SEPARATOR, $params);
    }
}
