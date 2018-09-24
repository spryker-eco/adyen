<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Zed\Adyen\Business\Logger;

use Generated\Shared\Transfer\AdyenApiRequestTransfer;
use Generated\Shared\Transfer\AdyenApiResponseTransfer;
use SprykerEco\Zed\Adyen\Business\Writer\AdyenWriterInterface;

class AdyenLogger implements AdyenLoggerInterface
{
    /**
     * @var \SprykerEco\Zed\Adyen\Business\Writer\AdyenWriterInterface
     */
    protected $writer;

    /**
     * @param \SprykerEco\Zed\Adyen\Business\Writer\AdyenWriterInterface $writer
     */
    public function __construct(AdyenWriterInterface $writer)
    {
        $this->writer = $writer;
    }

    /**
     * @param string $type
     * @param \Generated\Shared\Transfer\AdyenApiRequestTransfer $request
     * @param \Generated\Shared\Transfer\AdyenApiResponseTransfer $response
     *
     * @return void
     */
    public function log(string $type, AdyenApiRequestTransfer $request, AdyenApiResponseTransfer $response): void
    {
        $this->writer->saveApiLog($type, $request, $response);
    }
}
