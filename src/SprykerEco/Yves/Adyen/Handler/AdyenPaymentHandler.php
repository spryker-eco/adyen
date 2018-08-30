<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Yves\Adyen\Handler;

use Generated\Shared\Transfer\QuoteTransfer;
use SprykerEco\Shared\Adyen\AdyenConfig as SharedAdyenConfig;
use SprykerEco\Yves\Adyen\AdyenConfig;
use Symfony\Component\HttpFoundation\Request;

class AdyenPaymentHandler implements AdyenPaymentHandlerInterface
{
    /**
     * @var \SprykerEco\Yves\Adyen\AdyenConfig
     */
    protected $config;

    /**
     * @param \SprykerEco\Yves\Adyen\AdyenConfig $config
     */
    public function __construct(AdyenConfig $config)
    {
        $this->config = $config;
    }

    /**
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @param \Generated\Shared\Transfer\QuoteTransfer $quoteTransfer
     *
     * @return \Generated\Shared\Transfer\QuoteTransfer
     */
    public function addPaymentToQuote(Request $request, QuoteTransfer $quoteTransfer)
    {
        $paymentSelection = $quoteTransfer->getPayment()->getPaymentSelection();
        $quoteTransfer
            ->getPayment()
            ->setPaymentProvider(SharedAdyenConfig::PROVIDER_NAME)
            ->setPaymentMethod($paymentSelection);

        $quoteTransfer
            ->getPayment()
            ->getAdyenCreditCard()
            ->setEncryptedCardNumber($request->get('encryptedCardNumber'))
            ->setEncryptedExpiryMonth($request->get('encryptedExpiryMonth'))
            ->setEncryptedExpiryYear($request->get('encryptedExpiryYear'))
            ->setEncryptedSecurityCode($request->get('encryptedSecurityCode'));

        return $quoteTransfer;
    }
}
