<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Zed\Adyen\Business\Hook\Saver\MakePayment;

use SprykerEco\Zed\Adyen\AdyenConfig;
use SprykerEco\Zed\Adyen\Business\Writer\AdyenWriterInterface;

abstract class AbstractSaver
{
    protected $writer;
    protected $config;

    abstract protected function getRequestType();

    public function __construct(AdyenWriterInterface $writer, AdyenConfig $config)
    {
        $this->writer = $writer;
        $this->config = $config;
    }

    protected function log($request, $response)
    {
        $this->writer->savePaymentAdyenApiLog(
            $this->getRequestType(),
            $request,
            $response
        );
    }
}
