<?php

/**
 * MIT License
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerEcoTest\Zed\Adyen\Business;

use Generated\Shared\Transfer\OrderTransfer;

/**
 * @group Functional
 * @group SprykerEco
 * @group Zed
 * @group Adyen
 * @group Business
 */
class FacadeTest extends BaseSetUpTest
{
    protected const PROCESS_NAME_ADYEN_CREDIT_CARD = 'AdyenCreditCard01';
    protected const PROCESS_NAME_ADYEN_SOFORT = 'AdyenSofort01';
    protected const OMS_STATUS_NEW = 'new';
    protected const OMS_STATUS_AUTHORIZED = 'authorized';
    protected const OMS_STATUS_CAPTURED = 'captured';
    protected const OMS_STATUS_CANCELLATION_PENDING = 'cancellation pending';
    protected const OMS_STATUS_CAPTURE_PENDING = 'capture pending';
    protected const OMS_STATUS_REFUND_PENDING = 'refund pending';

    /**
     * @return void
     */
    public function testFilterPaymentMethods(): void
    {
        $this->markTestSkipped('It\'s not implemented yet.');
    }

    /**
     * @return void
     */
    public function testHandleAuthorizeCommand(): void
    {
        $this->markTestSkipped('It\'s not used.');
    }

    /**
     * @return void
     */
    public function testHandleCancelCommand(): void
    {
        $facade = $this->createFacade();
        $orderTransfer = $this->setUpCommandTest(
            static::PROCESS_NAME_ADYEN_CREDIT_CARD,
            static::OMS_STATUS_AUTHORIZED
        );
        $items = $this->getSpySalesOrderItems($orderTransfer);
        $facade->handleCancelCommand($items, $orderTransfer, []);

        foreach ($this->getSpySalesOrderItems($orderTransfer) as $item) {
            /** @var \Orm\Zed\Sales\Persistence\SpySalesOrderItem $item */
            $paymentAdyenOrderItem = $item->getSpyPaymentAdyenOrderItems()->getLast();
            $this->assertEquals(static::OMS_STATUS_CANCELLATION_PENDING, $paymentAdyenOrderItem->getStatus());
            $this->assertNotEmpty($paymentAdyenOrderItem->getSpyPaymentAdyen()->getPspReference());
        }
    }

    /**
     * @return void
     */
    public function testHandleCaptureCommand(): void
    {
        $facade = $this->createFacade();
        $orderTransfer = $this->setUpCommandTest(
            static::PROCESS_NAME_ADYEN_CREDIT_CARD,
            static::OMS_STATUS_AUTHORIZED
        );
        $items = $this->getSpySalesOrderItems($orderTransfer);
        $facade->handleCaptureCommand($items, $orderTransfer, []);

        foreach ($this->getSpySalesOrderItems($orderTransfer) as $item) {
            /** @var \Orm\Zed\Sales\Persistence\SpySalesOrderItem $item */
            $paymentAdyenOrderItem = $item->getSpyPaymentAdyenOrderItems()->getLast();
            $this->assertEquals(static::OMS_STATUS_CAPTURE_PENDING, $paymentAdyenOrderItem->getStatus());
            $this->assertNotEmpty($paymentAdyenOrderItem->getSpyPaymentAdyen()->getPspReference());
        }
    }

    /**
     * @return void
     */
    public function testHandleRefundCommand(): void
    {
        $facade = $this->createFacade();
        $orderTransfer = $this->setUpCommandTest(
            static::PROCESS_NAME_ADYEN_CREDIT_CARD,
            static::OMS_STATUS_CAPTURED
        );
        $items = $this->getSpySalesOrderItems($orderTransfer);
        $facade->handleRefundCommand($items, $orderTransfer, []);

        foreach ($this->getSpySalesOrderItems($orderTransfer) as $item) {
            /** @var \Orm\Zed\Sales\Persistence\SpySalesOrderItem $item */
            $paymentAdyenOrderItem = $item->getSpyPaymentAdyenOrderItems()->getLast();
            $this->assertEquals(static::OMS_STATUS_REFUND_PENDING, $paymentAdyenOrderItem->getStatus());
            $this->assertNotEmpty($paymentAdyenOrderItem->getSpyPaymentAdyen()->getPspReference());
        }
    }

    /**
     * @return void
     */
    public function testHandleCancelOrRefundCommand(): void
    {
        $facade = $this->createFacade();
        $orderTransfer = $this->setUpCommandTest(
            static::PROCESS_NAME_ADYEN_SOFORT,
            static::OMS_STATUS_CAPTURED
        );
        $items = $this->getSpySalesOrderItems($orderTransfer);
        $facade->handleCancelOrRefundCommand($items, $orderTransfer, []);

        foreach ($this->getSpySalesOrderItems($orderTransfer) as $item) {
            /** @var \Orm\Zed\Sales\Persistence\SpySalesOrderItem $item */
            $paymentAdyenOrderItem = $item->getSpyPaymentAdyenOrderItems()->getLast();
            $this->assertEquals(static::OMS_STATUS_REFUND_PENDING, $paymentAdyenOrderItem->getStatus());
            $this->assertNotEmpty($paymentAdyenOrderItem->getSpyPaymentAdyen()->getPspReference());
        }
    }

    /**
     * @return void
     */
    public function testSaveOrderPayment(): void
    {
        $this->markTestSkipped('Will be covered soon.');
    }

    /**
     * @return void
     */
    public function testExecutePostSaveHook(): void
    {
        $this->markTestSkipped('Will be covered soon.');
    }

    /**
     * @return void
     */
    public function testHandleNotification(): void
    {
        $facade = $this->createFacade();
        $orderTransfer = $this->setUpCommandTest(
            static::PROCESS_NAME_ADYEN_CREDIT_CARD,
            static::OMS_STATUS_CAPTURE_PENDING
        );
        $notificationsTransfer = $this->createNotificationsTransfer($orderTransfer, static::EVENT_CODE_CAPTURE);
        $facade->handleNotification($notificationsTransfer);

        foreach ($this->getSpySalesOrderItems($orderTransfer) as $item) {
            /** @var \Orm\Zed\Sales\Persistence\SpySalesOrderItem $item */
            $paymentAdyenOrderItem = $item->getSpyPaymentAdyenOrderItems()->getLast();
            $this->assertEquals(static::OMS_STATUS_CAPTURED, $paymentAdyenOrderItem->getStatus());
            $this->assertNotEmpty($paymentAdyenOrderItem->getSpyPaymentAdyen()->getPspReference());
        }
    }

    /**
     * @return void
     */
    public function testHandleNotificationWithAuthorizeEventAfterCaptureEvent(): void
    {
        // Arrange
        $facade = $this->createFacade();
        $orderTransfer = $this->setUpCommandTest(
            static::PROCESS_NAME_ADYEN_CREDIT_CARD,
            static::OMS_STATUS_NEW
        );

        // Act
        $notificationsTransferAuthorize = $this->createNotificationsTransfer($orderTransfer, static::EVENT_CODE_AUTHORISATION);
        $facade->handleNotification($notificationsTransferAuthorize);
        // Assert
        $this->assertSalesOrderItemStatus($orderTransfer, static::OMS_STATUS_AUTHORIZED);

        // Act
        $notificationsTransferCapture = $this->createNotificationsTransfer($orderTransfer, static::EVENT_CODE_CAPTURE);
        $facade->handleNotification($notificationsTransferCapture);
        // Assert
        $this->assertSalesOrderItemStatus($orderTransfer, static::OMS_STATUS_CAPTURED);

        //Act
        $facade->handleNotification($notificationsTransferAuthorize);
        // Assert
        $this->assertSalesOrderItemStatus($orderTransfer, static::OMS_STATUS_CAPTURED);
    }

    /**
     * @return void
     */
    protected function assertSalesOrderItemStatus(OrderTransfer $orderTransfer, string $status): void
    {
        foreach ($this->getSpySalesOrderItems($orderTransfer) as $item) {
            /** @var \Orm\Zed\Sales\Persistence\SpySalesOrderItem $item */
            $paymentAdyenOrderItem = $item->getSpyPaymentAdyenOrderItems()->getLast();
            $this->assertEquals($status, $paymentAdyenOrderItem->getStatus());
            $this->assertNotEmpty($paymentAdyenOrderItem->getSpyPaymentAdyen()->getPspReference());
        }
    }

    /**
     * @return void
     */
    public function testHandleOnlineTransferResponseFromAdyen(): void
    {
        $facade = $this->createFacade();
        $orderTransfer = $this->setUpCommandTest(
            static::PROCESS_NAME_ADYEN_SOFORT,
            static::OMS_STATUS_NEW
        );
        $redirectResponseTransfer = $this->createRedirectResponseTransfer($orderTransfer);
        $result = $facade->handleOnlineTransferResponseFromAdyen($redirectResponseTransfer);

        $this->assertTrue($result->getIsSuccess());
        foreach ($this->getSpySalesOrderItems($orderTransfer) as $item) {
            /** @var \Orm\Zed\Sales\Persistence\SpySalesOrderItem $item */
            $paymentAdyenOrderItem = $item->getSpyPaymentAdyenOrderItems()->getLast();
            $this->assertNotEmpty($paymentAdyenOrderItem->getSpyPaymentAdyen()->getPspReference());
        }
    }

    /**
     * @return void
     */
    public function testHandleOnlineTransferResponseFromAdyenAfterNotification(): void
    {
        // Arrange
        $facade = $this->createFacade();
        $orderTransfer = $this->setUpCommandTest(
            static::PROCESS_NAME_ADYEN_SOFORT,
            static::OMS_STATUS_AUTHORIZED
        );
        $redirectResponseTransfer = $this->createRedirectResponseTransfer($orderTransfer);

        //Act
        $result = $facade->handleOnlineTransferResponseFromAdyen($redirectResponseTransfer);

        // Assert
        $this->assertTrue($result->getIsSuccess());

        foreach ($this->getSpySalesOrderItems($orderTransfer) as $item) {
            // Assert
            /** @var \Orm\Zed\Sales\Persistence\SpySalesOrderItem $item */
            $paymentAdyenOrderItem = $item->getSpyPaymentAdyenOrderItems()->getLast();
            $this->assertNotEmpty($paymentAdyenOrderItem->getSpyPaymentAdyen()->getPspReference());
            $this->assertSame(static::OMS_STATUS_AUTHORIZED, $paymentAdyenOrderItem->getStatus());
        }
    }

    /**
     * @return void
     */
    public function testHandleCreditCard3dResponseFromAdyen(): void
    {
        $facade = $this->createFacade();
        $orderTransfer = $this->setUpCommandTest(
            static::PROCESS_NAME_ADYEN_CREDIT_CARD,
            static::OMS_STATUS_NEW
        );
        $redirectResponseTransfer = $this->createRedirectResponseTransfer($orderTransfer);
        $result = $facade->handleCreditCard3dResponseFromAdyen($redirectResponseTransfer);

        $this->assertTrue($result->getIsSuccess());
        foreach ($this->getSpySalesOrderItems($orderTransfer) as $item) {
            /** @var \Orm\Zed\Sales\Persistence\SpySalesOrderItem $item */
            $paymentAdyenOrderItem = $item->getSpyPaymentAdyenOrderItems()->getLast();
            $this->assertNotEmpty($paymentAdyenOrderItem->getSpyPaymentAdyen()->getPspReference());
        }
    }
}
