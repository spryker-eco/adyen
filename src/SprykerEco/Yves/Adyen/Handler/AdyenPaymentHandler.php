<?php

/**
 * MIT License
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerEco\Yves\Adyen\Handler;

use Generated\Shared\Transfer\QuoteTransfer;
use SprykerEco\Service\Adyen\AdyenServiceInterface;
use SprykerEco\Shared\Adyen\AdyenConfig;
use SprykerEco\Yves\Adyen\Plugin\Payment\AdyenPaymentMapperPluginInterface;
use Symfony\Component\HttpFoundation\Request;

class AdyenPaymentHandler implements AdyenPaymentHandlerInterface
{
    /**
     * @var \SprykerEco\Service\Adyen\AdyenServiceInterface
     */
    protected $service;

    /**
     * @var array|\SprykerEco\Yves\Adyen\Plugin\Payment\AdyenPaymentMapperPluginInterface[]
     */
    protected $paymentPlugins;

    /**
     * @param \SprykerEco\Service\Adyen\AdyenServiceInterface $service
     * @param \SprykerEco\Yves\Adyen\Plugin\Payment\AdyenPaymentMapperPluginInterface[] $paymentPlugins
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
        $paymentSelection = $quoteTransfer->getPaymentOrFail()->getPaymentSelectionOrFail();
        $quoteTransfer
            ->getPaymentOrFail()
            ->setPaymentProvider(AdyenConfig::PROVIDER_NAME)
            ->setPaymentMethod($paymentSelection);

        $quoteTransfer
            ->getPaymentOrFail()
            ->getAdyenPaymentOrFail()
            ->setReference($this->service->generateReference($quoteTransfer))
            ->setClientIp($request->getClientIp());

        $this->executeAdyenPaymentPlugins($request, $quoteTransfer);

        return $quoteTransfer;
    }

    /**
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @param \Generated\Shared\Transfer\QuoteTransfer $quoteTransfer
     *
     * @return void
     */
    protected function executeAdyenPaymentPlugins(Request $request, QuoteTransfer $quoteTransfer): void
    {
        foreach ($this->paymentPlugins as $plugin) {
            if ($plugin instanceof AdyenPaymentMapperPluginInterface) {
                $plugin->setPaymentDataToQuote($quoteTransfer, $request);
            }
        }
    }
}
