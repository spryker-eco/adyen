<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Yves\Adyen\Handler;

use Generated\Shared\Transfer\QuoteTransfer;
use SprykerEco\Service\Adyen\AdyenServiceInterface;
use SprykerEco\Shared\Adyen\AdyenConfig;
use Symfony\Component\HttpFoundation\Request;

class AdyenPaymentHandler implements AdyenPaymentHandlerInterface
{
    /**
     * @var \SprykerEco\Service\Adyen\AdyenServiceInterface
     */
    protected $service;

    /**
     * @param \SprykerEco\Service\Adyen\AdyenServiceInterface $service
     */
    public function __construct(AdyenServiceInterface $service)
    {
        $this->service = $service;
    }

    /**
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @param \Generated\Shared\Transfer\QuoteTransfer $quoteTransfer
     *
     * @return \Generated\Shared\Transfer\QuoteTransfer
     */
    public function addPaymentToQuote(Request $request, QuoteTransfer $quoteTransfer): QuoteTransfer
    {
        $paymentSelection = $quoteTransfer->getPayment()->getPaymentSelection();
        $quoteTransfer
            ->getPayment()
            ->setPaymentProvider(AdyenConfig::PROVIDER_NAME)
            ->setPaymentMethod($paymentSelection);

        $quoteTransfer
            ->getPayment()
            ->getAdyenPayment()
            ->setReference($this->service->generateReference($quoteTransfer));

        if (false) {
            $quoteTransfer
                ->getPayment()
                ->getAdyenCreditCard()
                ->setEncryptedCardNumber($request->get('encryptedCardNumber'))
                ->setEncryptedExpiryMonth($request->get('encryptedExpiryMonth'))
                ->setEncryptedExpiryYear($request->get('encryptedExpiryYear'))
                ->setEncryptedSecurityCode($request->get('encryptedSecurityCode'));
        }

        return $quoteTransfer;
    }
}
