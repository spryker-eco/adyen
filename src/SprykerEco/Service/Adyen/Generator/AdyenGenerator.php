<?php

/**
 * MIT License
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerEco\Service\Adyen\Generator;

use Generated\Shared\Transfer\QuoteTransfer;
use Spryker\Service\UtilText\Model\Hash;
use SprykerEco\Service\Adyen\Dependency\Service\AdyenToUtilTextServiceInterface;

class AdyenGenerator implements AdyenGeneratorInterface
{
    /**
     * @var string
     */
    protected const PARAMETERS_SEPARATOR = '-';

    /**
     * @var int
     */
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
            $this->generateUniqueSalt(),
            $quoteTransfer->getTotals()->getHash(),
        ];

        $string = $this->textService->hashValue(implode(static::PARAMETERS_SEPARATOR, $parameters), Hash::SHA256);

        return $this->getLimitedReference($string);
    }

    /**
     * @return string
     */
    protected function generateUniqueSalt(): string
    {
        $params = [
            time(),
            rand(100, 1000),
        ];

        return implode(static::PARAMETERS_SEPARATOR, $params);
    }

    /**
     * @param string $string
     *
     * @return string
     */
    protected function getLimitedReference(string $string): string
    {
        return substr($string, 0, static::REFERENCE_LENGTH);
    }
}
