<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Zed\Adyen\Business\Oms\Saver;

use Generated\Shared\Transfer\AdyenApiRequestTransfer;
use Generated\Shared\Transfer\AdyenApiResponseTransfer;
use SprykerEco\Zed\Adyen\AdyenConfig;
use SprykerEco\Zed\Adyen\Business\Reader\AdyenReaderInterface;
use SprykerEco\Zed\Adyen\Business\Writer\AdyenWriterInterface;
use SprykerEco\Zed\Adyen\Dependency\Facade\AdyenToOmsFacadeInterface;

abstract class AbstractCommandSaver implements AdyenCommandSaverInterface
{
    /**
     * @var \SprykerEco\Zed\Adyen\Dependency\Facade\AdyenToOmsFacadeInterface
     */
    protected $omsFacade;

    /**
     * @var \SprykerEco\Zed\Adyen\Business\Reader\AdyenReaderInterface
     */
    protected $reader;

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
     * @param \SprykerEco\Zed\Adyen\Dependency\Facade\AdyenToOmsFacadeInterface $omsFacade
     * @param \SprykerEco\Zed\Adyen\Business\Reader\AdyenReaderInterface $reader
     * @param \SprykerEco\Zed\Adyen\Business\Writer\AdyenWriterInterface $writer
     * @param \SprykerEco\Zed\Adyen\AdyenConfig $config
     */
    public function __construct(
        AdyenToOmsFacadeInterface $omsFacade,
        AdyenReaderInterface $reader,
        AdyenWriterInterface $writer,
        AdyenConfig $config
    ) {
        $this->omsFacade = $omsFacade;
        $this->reader = $reader;
        $this->writer = $writer;
        $this->config = $config;
    }

    /**
     * @param \Generated\Shared\Transfer\AdyenApiRequestTransfer $requestTransfer
     * @param \Generated\Shared\Transfer\AdyenApiResponseTransfer $responseTransfer
     *
     * @return void
     */
    public function logResponse(
        AdyenApiRequestTransfer $requestTransfer,
        AdyenApiResponseTransfer $responseTransfer
    ): void {
        $this->writer->savePaymentAdyenApiLog(
            $this->getRequestType(),
            $requestTransfer,
            $responseTransfer
        );
    }
}
