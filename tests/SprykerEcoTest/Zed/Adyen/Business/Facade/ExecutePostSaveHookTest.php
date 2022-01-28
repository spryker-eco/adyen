<?php

/**
 * MIT License
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerEcoTest\Zed\Adyen\Business\Facade;

use Generated\Shared\DataBuilder\AdyenApiResponseBuilder;
use Generated\Shared\Transfer\AdyenApiMakePaymentResponseTransfer;
use Generated\Shared\Transfer\AdyenApiResponseTransfer;
use Generated\Shared\Transfer\CheckoutResponseTransfer;
use Spryker\Shared\Kernel\Transfer\Exception\NullValueException;
use SprykerEco\Zed\Adyen\Dependency\Facade\AdyenToAdyenApiFacadeBridge;
use SprykerEcoTest\Zed\Adyen\Business\BaseSetUpTest;

/**
 * @group Functional
 * @group SprykerEco
 * @group Zed
 * @group Adyen
 * @group Business
 * @group Facade
 */
class ExecutePostSaveHookTest extends BaseSetUpTest
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
     * @var string
     */
    protected const PAYMENT_ADYEN_REFERENCE_STUB = 'payment-adyen-reference';

    /**
     * @return void
     */
    public function testExecutePostSaveHookShouldNotProcessErrorsWhenResponseIsSuccessAndDoesNotHaveRefusalStatus(): void
    {
        // Arrange
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

        $adyenFacade = $this->createFacade($adyenToAdyenApiFacadeBridgeMock);

        $orderTransfer = $this->setUpCommandTest(
            static::PROCESS_NAME_ADYEN_CREDIT_CARD,
            static::OMS_STATUS_NEW,
        );

        $checkoutResponseTransfer = new CheckoutResponseTransfer();

        // Act
        $adyenFacade->executePostSaveHook(
            $this->tester->buildQuoteTransfer($this->getPaymentAdyenReference($orderTransfer->getIdSalesOrder())),
            $checkoutResponseTransfer,
        );

        // Assert
        $this->assertCount(0, $checkoutResponseTransfer->getErrors());

        $this->assertNotFalse($checkoutResponseTransfer->getIsSuccess());

        $paymentAdyenApiLogEntity = $this->findLastPaymentAdyenApiLog();
        $this->assertNotNull($paymentAdyenApiLogEntity);
        $this->assertSame(static::MAKE_PAYMENT_PAY_PAL_REQUEST_TYPE, $paymentAdyenApiLogEntity->getType());
        $this->assertTrue($paymentAdyenApiLogEntity->getIsSuccess());

        $paymentAdyenEntity = $this->findPaymentAdyen($orderTransfer);
        $this->assertNotNull($paymentAdyenEntity);
        $this->assertSame(static::MAKE_PAYMENT_RESPONSE_PAYMENT_DATA, $paymentAdyenEntity->getPaymentData());
        $this->assertSame(json_encode(static::MAKE_PAYMENT_RESPONSE_DETAILS), $paymentAdyenEntity->getDetails());
    }

    /**
     * @return void
     */
    public function testExecutePostSaveHookShouldProcessErrorsWhenResponseIsNotSuccess(): void
    {
        // Arrange
        $adyenApiResponseTransfer = (new AdyenApiResponseBuilder([
                AdyenApiResponseTransfer::IS_SUCCESS => false,
            ]))
            ->withMakePaymentResponse([AdyenApiMakePaymentResponseTransfer::RESULT_CODE => static::ADYEN_PAYMENT_STATUS_AUTHORISED])
            ->withError()
            ->build();

        $adyenToAdyenApiFacadeBridgeMock = $this->createMock(AdyenToAdyenApiFacadeBridge::class);
        $adyenToAdyenApiFacadeBridgeMock->method('performMakePaymentApiCall')
            ->willReturn($adyenApiResponseTransfer);

        $adyenFacade = $this->createFacade($adyenToAdyenApiFacadeBridgeMock);

        $orderTransfer = $this->setUpCommandTest(
            static::PROCESS_NAME_ADYEN_CREDIT_CARD,
            static::OMS_STATUS_NEW,
        );

        $checkoutResponseTransfer = new CheckoutResponseTransfer();

        // Act
        $adyenFacade->executePostSaveHook(
            $this->tester->buildQuoteTransfer($this->getPaymentAdyenReference($orderTransfer->getIdSalesOrder())),
            $checkoutResponseTransfer,
        );

        // Assert
        $this->assertCount(1, $checkoutResponseTransfer->getErrors());

        $this->assertFalse($checkoutResponseTransfer->getIsSuccess());

        $checkoutErrorTransfer = $checkoutResponseTransfer->getErrors()->getIterator()->current();
        /** @var \Generated\Shared\Transfer\CheckoutErrorTransfer $checkoutErrorTransfer */
        $this->assertSame(static::ERROR_CODE_PAYMENT_FAILED, $checkoutErrorTransfer->getErrorCode());
        $this->assertSame(static::ERROR_TYPE_PAYMENT_FAILED, $checkoutErrorTransfer->getErrorType());

        $paymentAdyenApiLogEntity = $this->findLastPaymentAdyenApiLog();
        $this->assertNotNull($paymentAdyenApiLogEntity);
        $this->assertSame(static::MAKE_PAYMENT_PAY_PAL_REQUEST_TYPE, $paymentAdyenApiLogEntity->getType());
        $this->assertFalse($paymentAdyenApiLogEntity->getIsSuccess());

        $paymentAdyenEntity = $this->findPaymentAdyen($orderTransfer);
        $this->assertNotNull($paymentAdyenEntity);
        $this->assertNull($paymentAdyenEntity->getPaymentData());
        $this->assertNull($paymentAdyenEntity->getDetails());
    }

    /**
     * @dataProvider refusalStatusDataProvider
     *
     * @param string $refusalStatus
     *
     * @return void
     */
    public function testExecutePostSaveHookShouldProcessErrorsWhenResponseIsSuccessAndHasRefusalStatus(string $refusalStatus): void
    {
        // Arrange
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

        $adyenFacade = $this->createFacade($adyenToAdyenApiFacadeBridgeMock);

        $orderTransfer = $this->setUpCommandTest(
            static::PROCESS_NAME_ADYEN_CREDIT_CARD,
            static::OMS_STATUS_NEW,
        );

        $checkoutResponseTransfer = new CheckoutResponseTransfer();

        // Act
        $adyenFacade->executePostSaveHook(
            $this->tester->buildQuoteTransfer($this->getPaymentAdyenReference($orderTransfer->getIdSalesOrder())),
            $checkoutResponseTransfer,
        );

        // Assert
        $this->assertCount(1, $checkoutResponseTransfer->getErrors());

        $this->assertFalse($checkoutResponseTransfer->getIsSuccess());

        $checkoutErrorTransfer = $checkoutResponseTransfer->getErrors()->getIterator()->current();
        /** @var \Generated\Shared\Transfer\CheckoutErrorTransfer $checkoutErrorTransfer */
        $this->assertSame(static::ERROR_CODE_PAYMENT_FAILED, $checkoutErrorTransfer->getErrorCode());
        $this->assertSame(static::ERROR_TYPE_PAYMENT_FAILED, $checkoutErrorTransfer->getErrorType());

        $paymentAdyenApiLogEntity = $this->findLastPaymentAdyenApiLog();
        $this->assertNotNull($paymentAdyenApiLogEntity);
        $this->assertSame(static::MAKE_PAYMENT_PAY_PAL_REQUEST_TYPE, $paymentAdyenApiLogEntity->getType());
        $this->assertTrue($paymentAdyenApiLogEntity->getIsSuccess());

        $paymentAdyenEntity = $this->findPaymentAdyen($orderTransfer);
        $this->assertNotNull($paymentAdyenEntity);
        $this->assertSame(static::MAKE_PAYMENT_RESPONSE_PAYMENT_DATA, $paymentAdyenEntity->getPaymentData());
        $this->assertSame(json_encode(static::MAKE_PAYMENT_RESPONSE_DETAILS), $paymentAdyenEntity->getDetails());
    }

    /**
     * @return void
     */
    public function testExecutePostSaveHookWithoutMakePaymentResponse(): void
    {
        // Arrange
        $adyenApiResponseTransfer = (new AdyenApiResponseBuilder([
                AdyenApiResponseTransfer::IS_SUCCESS => true,
            ]))
            ->build();

        $adyenToAdyenApiFacadeBridgeMock = $this->createMock(AdyenToAdyenApiFacadeBridge::class);
        $adyenToAdyenApiFacadeBridgeMock->method('performMakePaymentApiCall')
            ->willReturn($adyenApiResponseTransfer);

        $adyenFacade = $this->createFacade($adyenToAdyenApiFacadeBridgeMock);

        $orderTransfer = $this->setUpCommandTest(
            static::PROCESS_NAME_ADYEN_CREDIT_CARD,
            static::OMS_STATUS_NEW,
        );

        $checkoutResponseTransfer = new CheckoutResponseTransfer();

        // Assert
        $this->expectException(NullValueException::class);

        // Act
        $adyenFacade->executePostSaveHook(
            $this->tester->buildQuoteTransfer($this->getPaymentAdyenReference($orderTransfer->getIdSalesOrder())),
            $checkoutResponseTransfer,
        );
    }

    /**
     * @return void
     */
    public function testExecutePostSaveHookWithoutPayment(): void
    {
        // Arrange
        $quoteTransfer = $this->tester->buildQuoteTransfer(static::PAYMENT_ADYEN_REFERENCE_STUB);
        $quoteTransfer->setPayment(null);

        // Assert
        $this->expectException(NullValueException::class);

        // Act
        $this->tester->getFacade()->executePostSaveHook(
            $quoteTransfer,
            new CheckoutResponseTransfer(),
        );
    }

    /**
     * @return void
     */
    public function testExecutePostSaveHookWithoutAdyenPaymen(): void
    {
        // Arrange
        $quoteTransfer = $this->tester->buildQuoteTransfer(static::PAYMENT_ADYEN_REFERENCE_STUB);
        $quoteTransfer->getPayment()->setPaymentSelection(null);

        // Assert
        $this->expectException(NullValueException::class);

        // Act
        $this->tester->getFacade()->executePostSaveHook(
            $quoteTransfer,
            new CheckoutResponseTransfer(),
        );
    }

    /**
     * @return void
     */
    public function testExecutePostSaveHookWithoutPaymentSelection(): void
    {
        // Arrange
        $quoteTransfer = $this->tester->buildQuoteTransfer(static::PAYMENT_ADYEN_REFERENCE_STUB);
        $quoteTransfer->getPayment()->setAdyenPayment(null);

        // Assert
        $this->expectException(NullValueException::class);

        // Act
        $this->tester->getFacade()->executePostSaveHook(
            $quoteTransfer,
            new CheckoutResponseTransfer(),
        );
    }

    /**
     * @return void
     */
    public function testExecutePostSaveHookWithoutBillingAddress(): void
    {
        // Arrange
        $quoteTransfer = $this->tester->buildQuoteTransfer($this->getPaymentAdyenReference(1));
        $quoteTransfer->setBillingAddress(null);

        // Assert
        $this->expectException(NullValueException::class);

        // Act
        $this->tester->getFacade()->executePostSaveHook(
            $quoteTransfer,
            new CheckoutResponseTransfer(),
        );
    }

    /**
     * @return array<array<string>>
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
