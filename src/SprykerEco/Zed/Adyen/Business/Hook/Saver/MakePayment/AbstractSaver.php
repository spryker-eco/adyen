<?php

/**
 * MIT License
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerEco\Zed\Adyen\Business\Hook\Saver\MakePayment;

use Generated\Shared\Transfer\AdyenApiRequestTransfer;
use Generated\Shared\Transfer\AdyenApiResponseTransfer;
use Generated\Shared\Transfer\PaymentAdyenTransfer;
use SprykerEco\Zed\Adyen\AdyenConfig;
use SprykerEco\Zed\Adyen\Business\Reader\AdyenReaderInterface;
use SprykerEco\Zed\Adyen\Business\Writer\AdyenWriterInterface;
use SprykerEco\Zed\Adyen\Dependency\Service\AdyenToUtilEncodingServiceInterface;

abstract class AbstractSaver implements AdyenSaverInterface
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
     * @var \SprykerEco\Zed\Adyen\Dependency\Service\AdyenToUtilEncodingServiceInterface
     */
    protected $encodingService;

    /**
     * @var \SprykerEco\Zed\Adyen\AdyenConfig
     */
    protected $config;

    /**
     * @return string
     */
    abstract protected function getRequestType(): string;

    /**
     * @param \SprykerEco\Zed\Adyen\Business\Reader\AdyenReaderInterface $reader
     * @param \SprykerEco\Zed\Adyen\Business\Writer\AdyenWriterInterface $writer
     * @param \SprykerEco\Zed\Adyen\Dependency\Service\AdyenToUtilEncodingServiceInterface $encodingService
     * @param \SprykerEco\Zed\Adyen\AdyenConfig $config
     */
    public function __construct(
        AdyenReaderInterface $reader,
        AdyenWriterInterface $writer,
        AdyenToUtilEncodingServiceInterface $encodingService,
        AdyenConfig $config
    ) {
        $this->reader = $reader;
        $this->writer = $writer;
        $this->encodingService = $encodingService;
        $this->config = $config;
    }

    /**
     * @param \Generated\Shared\Transfer\AdyenApiRequestTransfer $request
     * @param \Generated\Shared\Transfer\AdyenApiResponseTransfer $response
     *
     * @return void
     */
    public function save(AdyenApiRequestTransfer $request, AdyenApiResponseTransfer $response): void
    {
        $this->log($request, $response);

        if (!$response->getIsSuccess()) {
            return;
        }

        $paymentAdyenTransfer = $this->reader->getPaymentAdyenByReference(
            $request->getMakePaymentRequest()->getReference()
        );

        $paymentAdyenTransfer = $this->updatePaymentAdyenTransfer($response, $paymentAdyenTransfer);
        $this->updatePaymentEntities($paymentAdyenTransfer);
    }

    /**
     * @param \Generated\Shared\Transfer\AdyenApiResponseTransfer $response
     * @param \Generated\Shared\Transfer\PaymentAdyenTransfer $paymentAdyenTransfer
     *
     * @return \Generated\Shared\Transfer\PaymentAdyenTransfer
     */
    protected function updatePaymentAdyenTransfer(
        AdyenApiResponseTransfer $response,
        PaymentAdyenTransfer $paymentAdyenTransfer
    ): PaymentAdyenTransfer {
        $paymentAdyenTransfer->setDetails(
            $this->encodingService->encodeJson($response->getMakePaymentResponse()->getDetails())
        );
        $paymentAdyenTransfer->setPaymentData($response->getMakePaymentResponse()->getPaymentData());

        return $paymentAdyenTransfer;
    }

    /**
     * @param \Generated\Shared\Transfer\PaymentAdyenTransfer $paymentAdyenTransfer
     *
     * @return void
     */
    protected function updatePaymentEntities(PaymentAdyenTransfer $paymentAdyenTransfer): void
    {
        $paymentAdyenOrderItemTransfers = $this->reader
            ->getAllPaymentAdyenOrderItemsByIdSalesOrder(
                $paymentAdyenTransfer->getFkSalesOrder()
            );

        $this->writer->updatePaymentEntities(
            $this->getPaymentStatus($paymentAdyenTransfer),
            $paymentAdyenOrderItemTransfers,
            $paymentAdyenTransfer
        );
    }

    /**
     * @param \Generated\Shared\Transfer\PaymentAdyenTransfer|null $paymentAdyenTransfer
     *
     * @return string
     */
    protected function getPaymentStatus(?PaymentAdyenTransfer $paymentAdyenTransfer = null): string
    {
        return $this->config->getOmsStatusNew();
    }

    /**
     * @param \Generated\Shared\Transfer\AdyenApiRequestTransfer $request
     * @param \Generated\Shared\Transfer\AdyenApiResponseTransfer $response
     *
     * @return void
     */
    protected function log(AdyenApiRequestTransfer $request, AdyenApiResponseTransfer $response): void
    {
        $this->writer->saveApiLog(
            $this->getRequestType(),
            $request,
            $response
        );
    }
}
