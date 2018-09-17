<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Zed\Adyen\Business\Handler;

use Generated\Shared\Transfer\AdyenRedirectResponseTransfer;
use SprykerEco\Zed\Adyen\AdyenConfig;
use SprykerEco\Zed\Adyen\Business\Reader\AdyenReaderInterface;
use SprykerEco\Zed\Adyen\Business\Writer\AdyenWriterInterface;

class SofortRedirectHandler implements AdyenRedirectHandlerInterface
{
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
     * @param \SprykerEco\Zed\Adyen\Business\Reader\AdyenReaderInterface $reader
     * @param \SprykerEco\Zed\Adyen\Business\Writer\AdyenWriterInterface $writer
     * @param \SprykerEco\Zed\Adyen\AdyenConfig $config
     */
    public function __construct(
        AdyenReaderInterface $reader,
        AdyenWriterInterface $writer,
        AdyenConfig $config
    ) {
        $this->reader = $reader;
        $this->writer = $writer;
        $this->config = $config;
    }

    /**
     * @param \Generated\Shared\Transfer\AdyenRedirectResponseTransfer $redirectResponseTransfer
     *
     * @return \Generated\Shared\Transfer\AdyenRedirectResponseTransfer
     */
    public function handle(AdyenRedirectResponseTransfer $redirectResponseTransfer): AdyenRedirectResponseTransfer
    {
        $paymentAdyenTransfer = $this->reader->getPaymentAdyenByReference($redirectResponseTransfer->getReference());
        $paymentAdyenOrderItems = $this->reader->getAllPaymentAdyenOrderItemsByIdSalesOrder($paymentAdyenTransfer->getFkSalesOrder());

        $this->writer->update(
            $this->config->getOmsStatusCaptured(),
            $paymentAdyenOrderItems,
            $paymentAdyenTransfer
        );

        $redirectResponseTransfer->setIsSuccess(true);

        return $redirectResponseTransfer;
    }
}
