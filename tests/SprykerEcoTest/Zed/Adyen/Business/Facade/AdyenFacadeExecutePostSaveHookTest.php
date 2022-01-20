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
    protected const MAKE_PAYMENT_PAY_PAL_REQUEST_TYPE = 'MakePayment[PayPal]';

    /**
     * @var array
     */
    protected const MAKE_PAYMENT_RESPONSE_DETAILS = ['details'];

    /**
     * @var string
     */
    protected const MAKE_PAYMENT_RESPONSE_PAYMENT_DATA = 'payment data';

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
     * @var string
     */
    protected const ERROR_TYPE_PAYMENT_FAILED = 'payment failed';

    /**
     * @var int
     */
    protected const ERROR_CODE_PAYMENT_FAILED = 399;

    /**
     * @return void
     */
    public function testExecutePostSaveHookShouldNotProcessErrorsWhenResponsIsSuccessAndDoesNotHaveRefusalStatus(): void
    {
        //Arrange
        $adyenApiResponseTransfer = (new AdyenApiResponseBuilder([
            AdyenApiResponseTransfer::IS_SUCCESS => true,
        ]))
            ->withMakePaymentResponse([
                AdyenApiMakePaymentResponseTransfer::RESULT_CODE => static::ADYEN_PAYMENT_STATUS_AUTHORISED,
                AdyenApiMakePaymentResponseTransfer::DETAILS => static::MAKE_PAYMENT_RESPONSE_DETAILS,
                AdyenApiMakePaymentResponseTransfer::PAYMENT_DATA => static::MAKE_PAYMENT_RESPONSE_PAYMENT_DATA,
            ])
            ->build();

        $adyenToAdyenApiFacadeBridgeMock = $this->createMock(AdyenToAdyenApiFacadeBridge::class);
        $adyenToAdyenApiFacadeBridgeMock->method('performMakePaymentApiCall')
            ->willReturn($adyenApiResponseTransfer);

        $facade = $this->createFacade($adyenToAdyenApiFacadeBridgeMock);

        $orderTransfer = $this->setUpCommandTest(
            static::PROCESS_NAME_ADYEN_CREDIT_CARD,
            static::OMS_STATUS_NEW,
        );

        $checkoutResponseTransfer = $this->tester->createCheckoutResponseTransfer();

        //Act
        $facade->executePostSaveHook(
            $this->tester->buildQuoteTransfer($this->getPaymentAdyenReference($orderTransfer->getIdSalesOrder())),
            $checkoutResponseTransfer,
        );

        //Assert
        $this->assertCount(0, $checkoutResponseTransfer->getErrors());

        $this->assertNotFalse($checkoutResponseTransfer->getIsSuccess());

        $spyPaymentAdyenApiLog = $this->getLastSpyPaymentAdyenApiLog();
        $this->assertSame(static::MAKE_PAYMENT_PAY_PAL_REQUEST_TYPE, $spyPaymentAdyenApiLog->getType());
        $this->assertTrue($spyPaymentAdyenApiLog->getIsSuccess());

        $spyPaymentAdyen = $this->getSpyPaymentAdyen($orderTransfer);
        $this->assertSame(static::MAKE_PAYMENT_RESPONSE_PAYMENT_DATA, $spyPaymentAdyen->getPaymentData());
        $this->assertSame(json_encode(static::MAKE_PAYMENT_RESPONSE_DETAILS), $spyPaymentAdyen->getDetails());
    }

    /**
     * @return void
     */
    public function testExecutePostSaveHookShouldProcessErrorsWhenResponsIsNotSuccess(): void
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

        $checkoutResponseTransfer = $this->tester->createCheckoutResponseTransfer();

        //Act
        $facade->executePostSaveHook(
            $this->tester->buildQuoteTransfer($this->getPaymentAdyenReference($orderTransfer->getIdSalesOrder())),
            $checkoutResponseTransfer,
        );

        //Assert
        $this->assertCount(1, $checkoutResponseTransfer->getErrors());

        $this->assertFalse($checkoutResponseTransfer->getIsSuccess());

        $checkoutErrorTransfer = $checkoutResponseTransfer->getErrors()->getIterator()->current();
        /** @var \Generated\Shared\Transfer\CheckoutErrorTransfer $checkoutErrorTransfer */
        $this->assertSame(static::ERROR_CODE_PAYMENT_FAILED, $checkoutErrorTransfer->getErrorCode());
        $this->assertSame(static::ERROR_TYPE_PAYMENT_FAILED, $checkoutErrorTransfer->getErrorType());

        $spyPaymentAdyenApiLog = $this->getLastSpyPaymentAdyenApiLog();
        $this->assertSame(static::MAKE_PAYMENT_PAY_PAL_REQUEST_TYPE, $spyPaymentAdyenApiLog->getType());
        $this->assertFalse($spyPaymentAdyenApiLog->getIsSuccess());

        $spyPaymentAdyen = $this->getSpyPaymentAdyen($orderTransfer);
        $this->assertNull($spyPaymentAdyen->getPaymentData());
        $this->assertNull($spyPaymentAdyen->getDetails());
    }

    /**
     * @dataProvider refusalStatusDataProvider
     *
     * @param string $refusalStatus
     *
     * @return void
     */
    public function testExecutePostSaveHookShouldProcessErrorsWhenResponsIsSuccessAndHasRefusalStatus(string $refusalStatus): void
    {
        //Arrange
        $adyenApiResponseTransfer = (new AdyenApiResponseBuilder([
            AdyenApiResponseTransfer::IS_SUCCESS => true,
        ]))
            ->withMakePaymentResponse([
                AdyenApiMakePaymentResponseTransfer::RESULT_CODE => $refusalStatus,
                AdyenApiMakePaymentResponseTransfer::DETAILS => static::MAKE_PAYMENT_RESPONSE_DETAILS,
                AdyenApiMakePaymentResponseTransfer::PAYMENT_DATA => static::MAKE_PAYMENT_RESPONSE_PAYMENT_DATA,
            ])
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

        $checkoutResponseTransfer = $this->tester->createCheckoutResponseTransfer();

        //Act
        $facade->executePostSaveHook(
            $this->tester->buildQuoteTransfer($this->getPaymentAdyenReference($orderTransfer->getIdSalesOrder())),
            $checkoutResponseTransfer,
        );

        //Assert
        $this->assertCount(1, $checkoutResponseTransfer->getErrors());

        $this->assertFalse($checkoutResponseTransfer->getIsSuccess());

        $checkoutErrorTransfer = $checkoutResponseTransfer->getErrors()->getIterator()->current();
        /** @var \Generated\Shared\Transfer\CheckoutErrorTransfer $checkoutErrorTransfer */
        $this->assertSame(static::ERROR_CODE_PAYMENT_FAILED, $checkoutErrorTransfer->getErrorCode());
        $this->assertSame(static::ERROR_TYPE_PAYMENT_FAILED, $checkoutErrorTransfer->getErrorType());

        $spyPaymentAdyenApiLog = $this->getLastSpyPaymentAdyenApiLog();
        $this->assertSame(static::MAKE_PAYMENT_PAY_PAL_REQUEST_TYPE, $spyPaymentAdyenApiLog->getType());
        $this->assertTrue($spyPaymentAdyenApiLog->getIsSuccess());

        $spyPaymentAdyen = $this->getSpyPaymentAdyen($orderTransfer);
        $this->assertSame(static::MAKE_PAYMENT_RESPONSE_PAYMENT_DATA, $spyPaymentAdyen->getPaymentData());
        $this->assertSame(json_encode(static::MAKE_PAYMENT_RESPONSE_DETAILS), $spyPaymentAdyen->getDetails());
    }

    /**
     * @return array<array>
     */
    public function refusalStatusDataProvider(): array
    {
        return [
            [static::ADYEN_PAYMENT_STATUS_REFUSED],
            [static::ADYEN_PAYMENT_STATUS_CANCELLED],
            [static::ADYEN_PAYMENT_STATUS_ERROR],
        ];
    }
}
