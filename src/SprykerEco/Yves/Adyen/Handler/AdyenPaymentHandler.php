<?php

/**
 * MIT License
 * For full license information, please view the LICENSE file that was distributed with this source code.
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
     * @var array|\SprykerEco\Yves\Adyen\Plugin\Payment\AdyenPaymentPluginInterface[]
     */
    protected $paymentPlugins;

    /**
     * @param \SprykerEco\Service\Adyen\AdyenServiceInterface $service
     * @param \SprykerEco\Yves\Adyen\Plugin\Payment\AdyenPaymentPluginInterface[] $paymentPlugins
     */
    public function __construct(
        AdyenServiceInterface $service,
        array $paymentPlugins
    ) {
        $this->service = $service;
        $this->paymentPlugins = $paymentPlugins;
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

        if (array_key_exists($paymentSelection, $this->paymentPlugins)) {
            $plugin = $this->paymentPlugins[$paymentSelection];
            $plugin->setPaymentDataToQuote($quoteTransfer, $request);
        }

        return $quoteTransfer;
    }
}
