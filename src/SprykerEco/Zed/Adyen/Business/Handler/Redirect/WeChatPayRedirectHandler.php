<?php

/**
 * MIT License
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerEco\Zed\Adyen\Business\Handler\Redirect;

use Generated\Shared\Transfer\AdyenApiPaymentsDetailsRequestTransfer;
use Generated\Shared\Transfer\AdyenApiRequestTransfer;
use Generated\Shared\Transfer\AdyenRedirectResponseTransfer;
use Generated\Shared\Transfer\PaymentAdyenTransfer;
use SprykerEco\Shared\Adyen\AdyenSdkConfig;
use SprykerEco\Zed\Adyen\AdyenConfig;
use SprykerEco\Zed\Adyen\Business\Reader\AdyenReaderInterface;
use SprykerEco\Zed\Adyen\Business\Writer\AdyenWriterInterface;
use SprykerEco\Zed\Adyen\Dependency\Facade\AdyenToAdyenApiFacadeInterface;

class WeChatPayRedirectHandler implements AdyenRedirectHandlerInterface
{
    protected const REQUEST_TYPE = 'PaymentDetails[WeChatPay]';

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
        $paymentAdyenOrderItems = $this->reader->getAllPaymentAdyenOrderItemsByIdSalesOrder($paymentAdyenTransfer->getFkSalesOrder());

        $requestTransfer = $this->createDetailsRequestTransfer($redirectResponseTransfer, $paymentAdyenTransfer);
        $responseTransfer = $this->adyenApiFacade->performPaymentsDetailsApiCall($requestTransfer);

        $this->writer->saveApiLog(
            static::REQUEST_TYPE,
            $requestTransfer,
            $responseTransfer
        );

        if (!$responseTransfer->getIsSuccess()) {
            return $redirectResponseTransfer;
        }

        $paymentAdyenTransfer->setPspReference($responseTransfer->getPaymentsDetailsResponse()->getPspReference());

        $this->writer->updatePaymentEntities(
            $this->config->getOmsStatusAuthorizedAndCaptured(),
            $paymentAdyenOrderItems,
            $paymentAdyenTransfer
        );

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
        $requestTransfer->setPaymentsDetailsRequest(new AdyenApiPaymentsDetailsRequestTransfer());
        $requestTransfer->getPaymentsDetailsRequest()->setPaymentData($paymentAdyenTransfer->getPaymentData());
        $requestTransfer->getPaymentsDetailsRequest()->setDetails(
            [AdyenSdkConfig::PAYLOAD_FIELD => $redirectResponseTransfer->getPayload()]
        );

        return $requestTransfer;
    }
}
