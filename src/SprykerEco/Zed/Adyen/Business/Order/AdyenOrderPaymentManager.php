<?php

/**
 * MIT License
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerEco\Zed\Adyen\Business\Order;

use Generated\Shared\Transfer\QuoteTransfer;
use Generated\Shared\Transfer\SaveOrderTransfer;
use SprykerEco\Shared\Adyen\AdyenConfig;
use SprykerEco\Zed\Adyen\Business\Writer\AdyenWriterInterface;

class AdyenOrderPaymentManager implements AdyenOrderPaymentManagerInterface
{
    protected const ERROR_MESSAGE_PAYMENT_REFERENCE_NOT_UNIQUE = 'Adyene payment reference should be unique';

    /**
     * @var \SprykerEco\Zed\Adyen\Business\Writer\AdyenWriterInterface
     */
    protected $writer;

    /**
     * @var \SprykerEco\Zed\Adyen\Business\Reader\AdyenReaderInterface
     */
    protected $reader;

    /**
     * @param \SprykerEco\Zed\Adyen\Business\Writer\AdyenWriterInterface $writer
     * @param \SprykerEco\Zed\Adyen\Business\Reader\AdyenReaderInterface $reader
     */
    public function __construct(AdyenWriterInterface $writer, AdyenReaderInterface $reader)
    {
        $this->writer = $writer;
        $this->reader = $reader;
    }

    /**
     * @param \Generated\Shared\Transfer\QuoteTransfer $quoteTransfer
     * @param \Generated\Shared\Transfer\SaveOrderTransfer $saveOrderTransfer
     *
     * @return void
     */
    public function saveOrderPayment(QuoteTransfer $quoteTransfer, SaveOrderTransfer $saveOrderTransfer): void
    {
        if ($quoteTransfer->getPayment()->getPaymentProvider() !== AdyenConfig::PROVIDER_NAME) {
            return;
        }

        $paymentAdyenTransfer = $this->reader->getPaymentAdyenByReference($quoteTransfer->getPayment()->getAdyenPayment()->getReference());
        if ($paymentAdyenTransfer->getIdPaymentAdyen() !== null) {
            throw new AdyenMethodSaverException(static::ERROR_MESSAGE_REFERENCE_NOT_UNIQUE);
        }

        $this->writer->savePaymentEntities($quoteTransfer->getPayment(), $saveOrderTransfer);
    }
}
