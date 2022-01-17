<?php

/**
 * MIT License
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerEcoTest\Zed\Adyen;

use Codeception\Actor;
use Generated\Shared\DataBuilder\QuoteBuilder;
use Generated\Shared\Transfer\AdyenPaymentTransfer;
use Generated\Shared\Transfer\CheckoutResponseTransfer;
use Generated\Shared\Transfer\PaymentTransfer;
use Generated\Shared\Transfer\QuoteTransfer;
use SprykerEco\Shared\Adyen\AdyenConfig as AdyenConfigShared;

/**
 * Inherited Methods
 *
 * @method void wantToTest($text)
 * @method void wantTo($text)
 * @method void execute($callable)
 * @method void expectTo($prediction)
 * @method void expect($prediction)
 * @method void amGoingTo($argumentation)
 * @method void am($role)
 * @method void lookForwardTo($achieveValue)
 * @method void comment($description)
 * @method \Codeception\Lib\Friend haveFriend($name, $actorClass = NULL)
 *
 * @SuppressWarnings(PHPMD)
 */
class AdyenZedTester extends Actor
{
    use _generated\AdyenZedTesterActions;

    /**
     * @var string
     */
    protected const CLIENT_IP = '192.168.0.1';

    /**
     * @param string $reference
     *
     * @return \Generated\Shared\Transfer\QuoteTransfer
     */
    public function buildQuoteTransfer(string $reference): QuoteTransfer
    {
        $quoteBuilder = (new QuoteBuilder())
            ->withBillingAddress()
            ->withShippingAddress()
            ->withCurrency()
            ->withTotals()
            ->withCustomer()
            ->build();

        $quoteBuilder->setPayment($this->createPaymentTransfer($reference));

        return $quoteBuilder;
    }

    /**
     * @return \Generated\Shared\Transfer\CheckoutResponseTransfer
     */
    public function createCheckoutResponseTransfer(): CheckoutResponseTransfer
    {
        return (new CheckoutResponseTransfer());
    }

    /**
     * @param string $reference
     *
     * @return \Generated\Shared\Transfer\PaymentTransfer
     */
    protected function createPaymentTransfer(string $reference): PaymentTransfer
    {
        return (new PaymentTransfer())
            ->setPaymentSelection(PaymentTransfer::ADYEN_PAY_PAL)
            ->setAdyenPayment($this->createAdyenPaymentTransfer($reference))
            ->setPaymentProvider(AdyenConfigShared::PROVIDER_NAME);
    }

    /**
     * @param string $reference
     *
     * @return \Generated\Shared\Transfer\AdyenPaymentTransfer
     */
    protected function createAdyenPaymentTransfer(string $reference): AdyenPaymentTransfer
    {
        return (new AdyenPaymentTransfer())
            ->setReference($reference)
            ->setClientIp(static::CLIENT_IP);
    }
}
