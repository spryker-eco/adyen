<?php

/**
 * MIT License
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerEco\Zed\Adyen\Business\Handler\Redirect;

use Generated\Shared\Transfer\AdyenApiPaymentDetailsRequestTransfer;
use Generated\Shared\Transfer\AdyenApiRequestTransfer;
use Generated\Shared\Transfer\AdyenApiResponseTransfer;
use Generated\Shared\Transfer\AdyenRedirectResponseTransfer;
use Generated\Shared\Transfer\PaymentAdyenTransfer;
use SprykerEco\Shared\Adyen\AdyenApiRequestConfig;
use SprykerEco\Zed\Adyen\AdyenConfig;
use SprykerEco\Zed\Adyen\Business\Reader\AdyenReaderInterface;
use SprykerEco\Zed\Adyen\Business\Writer\AdyenWriterInterface;
use SprykerEco\Zed\Adyen\Dependency\Facade\AdyenToAdyenApiFacadeInterface;

class OnlineTransferRedirectHandler implements AdyenRedirectHandlerInterface
{
    protected const LOG_REQUEST_TYPE = 'PaymentDetails[%s]';

    /**
     * @var \SprykerEco\Zed\Adyen\Dependency\Facade\AdyenToAdyenApiFacadeInterface
     */
    protected $adyenApiFacade;

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
     * @param \SprykerEco\Zed\Adyen\Dependency\Facade\AdyenToAdyenApiFacadeInterface $adyenApiFacade
     * @param \SprykerEco\Zed\Adyen\Business\Reader\AdyenReaderInterface $reader
     * @param \SprykerEco\Zed\Adyen\Business\Writer\AdyenWriterInterface $writer
     * @param \SprykerEco\Zed\Adyen\AdyenConfig $config
     */
    public function __construct(
        AdyenToAdyenApiFacadeInterface $adyenApiFacade,
        AdyenReaderInterface $reader,
        AdyenWriterInterface $writer,
        AdyenConfig $config
    ) {
        $this->adyenApiFacade = $adyenApiFacade;
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

        $requestTransfer = $this->createDetailsRequestTransfer($redirectResponseTransfer, $paymentAdyenTransfer);
        $responseTransfer = $this->adyenApiFacade->performPaymentDetailsApiCall($requestTransfer);

        $this->writer->saveApiLog(
            sprintf(static::LOG_REQUEST_TYPE, $paymentAdyenTransfer->getPaymentMethod()),
            $requestTransfer,
            $responseTransfer
        );

        if (!$responseTransfer->getIsSuccess()) {
            return $redirectResponseTransfer;
        }

        $this->processPaymentDetailsResponse($paymentAdyenTransfer, $responseTransfer);
        $redirectResponseTransfer->setIsSuccess(true);

        return $redirectResponseTransfer;
    }

    /**
     * @param \Generated\Shared\Transfer\AdyenRedirectResponseTransfer $redirectResponseTransfer
     * @param \Generated\Shared\Transfer\PaymentAdyenTransfer $paymentAdyenTransfer
     *
     * @return \Generated\Shared\Transfer\AdyenApiRequestTransfer
     */
    protected function createDetailsRequestTransfer(
        AdyenRedirectResponseTransfer $redirectResponseTransfer,
        PaymentAdyenTransfer $paymentAdyenTransfer
    ): AdyenApiRequestTransfer {
        $requestTransfer = new AdyenApiRequestTransfer();
        $requestTransfer->setPaymentDetailsRequest(
            (new AdyenApiPaymentDetailsRequestTransfer())
                ->setPaymentData($paymentAdyenTransfer->getPaymentData())
                ->setDetails($this->getRequestDetails($redirectResponseTransfer))
        );

        return $requestTransfer;
    }

    /**
     * @param \Generated\Shared\Transfer\PaymentAdyenTransfer $paymentAdyenTransfer
     * @param \Generated\Shared\Transfer\AdyenApiResponseTransfer $responseTransfer
     *
     * @return void
     */
    protected function processPaymentDetailsResponse(PaymentAdyenTransfer $paymentAdyenTransfer, AdyenApiResponseTransfer $responseTransfer): void
    {
        $paymentAdyenTransfer->setPspReference($responseTransfer->getPaymentDetailsResponse()->getPspReference());
        $paymentAdyenOrderItems = $this->reader->getAllPaymentAdyenOrderItemsByIdSalesOrder($paymentAdyenTransfer->getFkSalesOrder());

        $omsStatus = $this->resolveOmsStatus($paymentAdyenOrderItems);

        $this->writer->updatePaymentEntities($omsStatus, $paymentAdyenOrderItems, $paymentAdyenTransfer);
    }

    /**
     * @return string
     */
    protected function getOmsStatus(): string
    {
        return $this->config->getOmsStatusNew();
    }

    /**
     * @param \Generated\Shared\Transfer\AdyenRedirectResponseTransfer $redirectResponseTransfer
     *
     * @return string[]
     */
    protected function getRequestDetails(AdyenRedirectResponseTransfer $redirectResponseTransfer): array
    {
        return [
            AdyenApiRequestConfig::PAYLOAD_FIELD => $redirectResponseTransfer->getPayload(),
            AdyenApiRequestConfig::REDIRECT_RESULT_FIELD => $redirectResponseTransfer->getRedirectResult(),
        ];
    }

    /**
     * @param \Generated\Shared\Transfer\PaymentAdyenOrderItemTransfer[] $paymentAdyenOrderItems
     *
     * @return string
     */
    protected function resolveOmsStatus(array $paymentAdyenOrderItems): string
    {
        $defaultOmsStatus = $this->getOmsStatus();
        $paymentOrderItem = reset($paymentAdyenOrderItems);
        if ($paymentOrderItem->getStatus() !== $defaultOmsStatus) {
            return $paymentOrderItem->getStatus();
        }

        return $defaultOmsStatus;
    }
}
