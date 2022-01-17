<?php

/**
 * MIT License
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerEcoTest\Zed\Adyen\Business\Facade;

use Generated\Shared\DataBuilder\AdyenApiResponseBuilder;
use Generated\Shared\Transfer\AdyenApiMakePaymentResponseTransfer;
use Generated\Shared\Transfer\AdyenApiResponseTransfer;
use SprykerEco\Zed\Adyen\Dependency\Facade\AdyenToAdyenApiFacadeBridge;
use SprykerEcoTest\Zed\Adyen\Business\BaseSetUpTest;

/**
 * @group Functional
 * @group SprykerEco
 * @group Zed
 * @group Adyen
 * @group Business
 */
class AdyenFacadeExecutePostSaveHookTest extends BaseSetUpTest
{
    /**
     * @var string
     */
    protected const PROCESS_NAME_ADYEN_CREDIT_CARD = 'AdyenPayPal01';

    /**
     * @var string
     */
    protected const OMS_STATUS_NEW = 'new';

    /**
     * @var string
     */
    protected const ADYEN_PAYMENT_STATUS_AUTHORISED = 'Authorised';

    /**
     * @var string
     */
    protected const ADYEN_PAYMENT_STATUS_REFUSED = 'Refused';

    /**
     * @var string
     */
    protected const ADYEN_PAYMENT_STATUS_ERROR = 'Error';

    /**
     * @var string
     */
    protected const ADYEN_PAYMENT_STATUS_CANCELLED = 'Cancelled';

    /**
     * @return void
     */
    public function testExecutePostSaveHookShouldNotContainErrorsWhenResponsIsSuccessAndDoesNotHaveRefusalStatus(): void
    {
        //Arrange
        $adyenApiResponseTransfer = (new AdyenApiResponseBuilder([
            AdyenApiResponseTransfer::IS_SUCCESS => true,
        ]))
            ->withMakePaymentResponse([AdyenApiMakePaymentResponseTransfer::RESULT_CODE => static::ADYEN_PAYMENT_STATUS_AUTHORISED])
            ->build();

        $adyenToAdyenApiFacadeBridgeMock = $this->createMock(AdyenToAdyenApiFacadeBridge::class);
        $adyenToAdyenApiFacadeBridgeMock->method('performMakePaymentApiCall')
            ->willReturn($adyenApiResponseTransfer);

        $facade = $this->createFacade($adyenToAdyenApiFacadeBridgeMock);

        $orderTransfer = $this->setUpCommandTest(
            static::PROCESS_NAME_ADYEN_CREDIT_CARD,
            static::OMS_STATUS_NEW,
        );

        $spyPaymentAdyen = $this->getSpyPaymentAdyen($orderTransfer);
        $checkoutResponseTransfer = $this->tester->createCheckoutResponseTransfer();

        //Act
        $facade->executePostSaveHook(
            $this->tester->buildQuoteTransfer($spyPaymentAdyen->getReference()),
            $checkoutResponseTransfer,
        );

        //Assert
        $this->assertSame(0, $checkoutResponseTransfer->getErrors()->count());
    }

    /**
     * @return void
     */
    public function testExecutePostSaveHookShouldContainErrorsWhenResponsIsNotSuccess(): void
    {
        //Arrange
        $adyenApiResponseTransfer = (new AdyenApiResponseBuilder([
            AdyenApiResponseTransfer::IS_SUCCESS => false,
        ]))
            ->withMakePaymentResponse([AdyenApiMakePaymentResponseTransfer::RESULT_CODE => static::ADYEN_PAYMENT_STATUS_AUTHORISED])
            ->withError()
            ->build();

        $adyenToAdyenApiFacadeBridgeMock = $this->createMock(AdyenToAdyenApiFacadeBridge::class);
        $adyenToAdyenApiFacadeBridgeMock->method('performMakePaymentApiCall')
            ->willReturn($adyenApiResponseTransfer);

        $facade = $this->createFacade($adyenToAdyenApiFacadeBridgeMock);

        $orderTransfer = $this->setUpCommandTest(
            static::PROCESS_NAME_ADYEN_CREDIT_CARD,
            static::OMS_STATUS_NEW,
        );

        $spyPaymentAdyen = $this->getSpyPaymentAdyen($orderTransfer);
        $checkoutResponseTransfer = $this->tester->createCheckoutResponseTransfer();

        //Act
        $facade->executePostSaveHook(
            $this->tester->buildQuoteTransfer($spyPaymentAdyen->getReference()),
            $checkoutResponseTransfer,
        );

        //Assert
        $this->assertSame(1, $checkoutResponseTransfer->getErrors()->count());
    }

    /**
     * @dataProvider refusalStatusDataProvider
     *
     * @param string $refusalStatus
     *
     * @return void
     */
    public function testExecutePostSaveHookShouldNotContainErrorsWhenResponsIsSuccessAndHasRefusalStatus(string $refusalStatus): void
    {
        //Arrange
        $adyenApiResponseTransfer = (new AdyenApiResponseBuilder([
            AdyenApiResponseTransfer::IS_SUCCESS => false,
        ]))
            ->withMakePaymentResponse([AdyenApiMakePaymentResponseTransfer::RESULT_CODE => static::ADYEN_PAYMENT_STATUS_AUTHORISED])
            ->withError()
            ->build();

        $adyenToAdyenApiFacadeBridgeMock = $this->createMock(AdyenToAdyenApiFacadeBridge::class);
        $adyenToAdyenApiFacadeBridgeMock->method('performMakePaymentApiCall')
            ->willReturn($adyenApiResponseTransfer);

        $facade = $this->createFacade($adyenToAdyenApiFacadeBridgeMock);

        $orderTransfer = $this->setUpCommandTest(
            static::PROCESS_NAME_ADYEN_CREDIT_CARD,
            static::OMS_STATUS_NEW,
        );

        $spyPaymentAdyen = $this->getSpyPaymentAdyen($orderTransfer);
        $checkoutResponseTransfer = $this->tester->createCheckoutResponseTransfer();

        //Act
        $facade->executePostSaveHook(
            $this->tester->buildQuoteTransfer($spyPaymentAdyen->getReference()),
            $checkoutResponseTransfer,
        );

        //Assert
        $this->assertSame(1, $checkoutResponseTransfer->getErrors()->count());
    }

    /**
     * @return array<array>
     */
    public function refusalStatusDataProvider(): array
    {
        return [
            [static::ADYEN_PAYMENT_STATUS_AUTHORISED],
            [static::ADYEN_PAYMENT_STATUS_CANCELLED],
            [static::ADYEN_PAYMENT_STATUS_ERROR],
        ];
    }
}
