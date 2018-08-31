<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Zed\Adyen\Business\Generator;

use Generated\Shared\Transfer\QuoteTransfer;
use Spryker\Service\UtilText\Model\Hash;
use Spryker\Service\UtilText\UtilTextServiceInterface;

class AdyenGenerator implements AdyenGeneratorInterface
{
    protected const PARAMETERS_SEPARATOR = '-';
    protected const REFERENCE_LENGTH = 80;

    /**
     * @var \Spryker\Service\UtilText\UtilTextServiceInterface
     */
    protected $textService;

    /**
     * @param \Spryker\Service\UtilText\UtilTextServiceInterface $textService
     */
    public function __construct(UtilTextServiceInterface $textService)
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
