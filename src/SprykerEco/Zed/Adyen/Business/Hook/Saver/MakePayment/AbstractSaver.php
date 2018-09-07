<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Zed\Adyen\Business\Hook\Saver\MakePayment;

use Generated\Shared\Transfer\AdyenApiRequestTransfer;
use Generated\Shared\Transfer\AdyenApiResponseTransfer;
use SprykerEco\Zed\Adyen\AdyenConfig;
use SprykerEco\Zed\Adyen\Business\Writer\AdyenWriterInterface;

abstract class AbstractSaver
{
    /**
     * @var \SprykerEco\Zed\Adyen\Business\Writer\AdyenWriterInterface
     */
    protected $writer;

    /**
     * @var \SprykerEco\Zed\Adyen\AdyenConfig
     */
    protected $config;

    /**
     * @return string
     */
    abstract protected function getRequestType(): string;

    /**
     * @param \SprykerEco\Zed\Adyen\Business\Writer\AdyenWriterInterface $writer
     * @param \SprykerEco\Zed\Adyen\AdyenConfig $config
     */
    public function __construct(AdyenWriterInterface $writer, AdyenConfig $config)
    {
        $this->writer = $writer;
        $this->config = $config;
    }

    /**
     * @param \Generated\Shared\Transfer\AdyenApiRequestTransfer $request
     * @param \Generated\Shared\Transfer\AdyenApiResponseTransfer $response
     *
     * @return void
     */
    protected function log(AdyenApiRequestTransfer $request, AdyenApiResponseTransfer $response): void
    {
        $this->writer->savePaymentAdyenApiLog(
            $this->getRequestType(),
            $request,
            $response
        );
    }
}
