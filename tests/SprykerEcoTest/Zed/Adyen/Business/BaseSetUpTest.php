<?php

/**
 * MIT License
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerEcoTest\Zed\Adyen\Business;

use Codeception\TestCase\Test;
use Generated\Shared\DataBuilder\AdyenApiAmountBuilder;
use Generated\Shared\DataBuilder\AdyenApiResponseBuilder;
use Generated\Shared\DataBuilder\AdyenNotificationRequestItemBuilder;
use Generated\Shared\DataBuilder\AdyenNotificationsBuilder;
use Generated\Shared\DataBuilder\AdyenRedirectResponseBuilder;
use Generated\Shared\DataBuilder\OrderBuilder;
use Generated\Shared\Transfer\AdyenApiAmountTransfer;
use Generated\Shared\Transfer\AdyenApiCancelOrRefundResponseTransfer;
use Generated\Shared\Transfer\AdyenApiCancelResponseTransfer;
use Generated\Shared\Transfer\AdyenApiCaptureResponseTransfer;
use Generated\Shared\Transfer\AdyenApiPaymentDetailsResponseTransfer;
use Generated\Shared\Transfer\AdyenApiRefundResponseTransfer;
use Generated\Shared\Transfer\AdyenApiResponseTransfer;
use Generated\Shared\Transfer\AdyenNotificationRequestItemTransfer;
use Generated\Shared\Transfer\AdyenNotificationsTransfer;
use Generated\Shared\Transfer\AdyenRedirectResponseTransfer;
use Generated\Shared\Transfer\OrderTransfer;
use Generated\Shared\Transfer\PaymentAdyenOrderItemTransfer;
use Generated\Shared\Transfer\PaymentAdyenTransfer;
use Generated\Shared\Transfer\TotalsTransfer;
use Orm\Zed\Adyen\Persistence\SpyPaymentAdyen;
use Orm\Zed\Adyen\Persistence\SpyPaymentAdyenApiLog;
use Orm\Zed\Adyen\Persistence\SpyPaymentAdyenApiLogQuery;
use Orm\Zed\Adyen\Persistence\SpyPaymentAdyenQuery;
use Orm\Zed\Sales\Persistence\SpySalesOrderItemQuery;
use Propel\Runtime\ActiveQuery\Criteria;
use Spryker\Shared\Oms\OmsConstants;
use SprykerEco\Shared\Adyen\AdyenConstants;
use SprykerEco\Zed\Adyen\AdyenConfig;
use SprykerEco\Zed\Adyen\Business\AdyenBusinessFactory;
use SprykerEco\Zed\Adyen\Business\AdyenFacade;
use SprykerEco\Zed\Adyen\Business\AdyenFacadeInterface;
use SprykerEco\Zed\Adyen\Dependency\Facade\AdyenToAdyenApiFacadeBridge;
use SprykerEco\Zed\Adyen\Dependency\Facade\AdyenToAdyenApiFacadeInterface;
use SprykerEco\Zed\Adyen\Dependency\Facade\AdyenToOmsFacadeBridge;
use SprykerEco\Zed\Adyen\Dependency\Facade\AdyenToOmsFacadeInterface;
use SprykerEco\Zed\Adyen\Dependency\Service\AdyenToUtilEncodingServiceBridge;
use SprykerEco\Zed\Adyen\Dependency\Service\AdyenToUtilEncodingServiceInterface;
use SprykerEco\Zed\Adyen\Persistence\AdyenEntityManager;
use SprykerEco\Zed\Adyen\Persistence\AdyenEntityManagerInterface;
use SprykerEco\Zed\Adyen\Persistence\AdyenRepository;
use SprykerEco\Zed\Adyen\Persistence\AdyenRepositoryInterface;

class BaseSetUpTest extends Test
{
    /**
     * @var string
     */
    protected const RESPONSE_REFERENCE = '8535408002754771';

    /**
     * @var string
     */
    protected const RESPONSE_CANCEL_RECEIVED = '[cancel-received]';

    /**
     * @var string
     */
    protected const RESPONSE_CAPTURE_RECEIVED = '[capture-received]';

    /**
     * @var string
     */
    protected const RESPONSE_REFUND_RECEIVED = '[refund-received]';

    /**
     * @var string
     */
    protected const RESPONSE_CANCEL_OR_REFUND_RECEIVED = '[cancelOrRefund-received]';

    /**
     * @var string
     */
    protected const RESPONSE_AUTHORISED = 'Authorised';

    /**
     * @var int
     */
    protected const AMOUNT = 1990;

    /**
     * @var string
     */
    protected const CURRENCY = 'EUR';

    /**
     * @var string
     */
    protected const FIELD_UNIT_PRICE = 'unitPrice';

    /**
     * @var string
     */
    protected const FIELD_SUM_PRICE = 'sumPrice';

    /**
     * @var string
     */
    protected const EVENT_CODE_AUTHORISATION = 'AUTHORISATION';

    /**
     * @var string
     */
    protected const EVENT_CODE_CAPTURE = 'CAPTURE';

    /**
     * @var string
     */
    protected const MERCHANT_ACCOUNT = 'TestMerchant';

    /**
     * @var string
     */
    protected const RESPONSE_SUCCESS_TRUE = 'true';

    /**
     * @var string
     */
    protected const REDIRECT_RESPONSE_PAYLOAD = 'random-payload-string';

    /**
     * @var string
     */
    protected const REDIRECT_RESPONSE_TYPE = 'complete';

    /**
     * @var string
     */
    protected const REDIRECT_RESPONSE_RESULT_CODE = 'authorised';

    /**
     * @var \SprykerEcoTest\Zed\Adyen\AdyenZedTester
     */
    protected $tester;

    /**
     * @param \SprykerEco\Zed\Adyen\Dependency\Facade\AdyenToAdyenApiFacadeInterface $adyenToAdyenApiFacade
     *
     * @return \SprykerEco\Zed\Adyen\Business\AdyenFacadeInterface
     */
    protected function createFacade(AdyenToAdyenApiFacadeInterface $adyenToAdyenApiFacade): AdyenFacadeInterface
    {
        $facade = (new AdyenFacade())
            ->setFactory($this->createFactory($adyenToAdyenApiFacade));

        return $facade;
    }

    /**
     * @param \SprykerEco\Zed\Adyen\Dependency\Facade\AdyenToAdyenApiFacadeInterface $adyenToAdyenApiFacade
     *
     * @return \PHPUnit_Framework_MockObject_MockObject|\SprykerEco\Zed\Adyen\Business\AdyenBusinessFactory
     */
    protected function createFactory(AdyenToAdyenApiFacadeInterface $adyenToAdyenApiFacade): AdyenBusinessFactory
    {
        $builder = $this->getMockBuilder(AdyenBusinessFactory::class);
        $builder->setMethods(
            [
                'getConfig',
                'getRepository',
                'getEntityManager',
                'getAdyenApiFacade',
                'getOmsFacade',
                'getUtilEncodingService',
            ],
        );

        $stub = $builder->getMock();
        $stub->method('getConfig')
            ->willReturn($this->createConfig());
        $stub->method('getRepository')
            ->willReturn($this->createRepository());
        $stub->method('getEntityManager')
            ->willReturn($this->createEntityManager());
        $stub->method('getAdyenApiFacade')
            ->willReturn($adyenToAdyenApiFacade);
        $stub->method('getOmsFacade')
            ->willReturn($this->createOmsFacade());
        $stub->method('getUtilEncodingService')
            ->willReturn($this->createUtilEncodingService());

        return $stub;
    }

    /**
     * @return \SprykerEco\Zed\Adyen\AdyenConfig
     */
    protected function createConfig(): AdyenConfig
    {
        return new AdyenConfig();
    }

    /**
     * @return \SprykerEco\Zed\Adyen\Persistence\AdyenRepositoryInterface
     */
    protected function createRepository(): AdyenRepositoryInterface
    {
        return new AdyenRepository();
    }

    /**
     * @return \SprykerEco\Zed\Adyen\Persistence\AdyenEntityManagerInterface
     */
    protected function createEntityManager(): AdyenEntityManagerInterface
    {
        return new AdyenEntityManager();
    }

    /**
     * @return \PHPUnit_Framework_MockObject_MockObject|\SprykerEco\Zed\Adyen\Dependency\Facade\AdyenToAdyenApiFacadeInterface
     */
    protected function createAdyenApiFacade(): AdyenToAdyenApiFacadeInterface
    {
        $stub = $this->createMock(AdyenToAdyenApiFacadeBridge::class);
        $stub->method('performCancelApiCall')
            ->willReturn($this->createResponseTransfer());
        $stub->method('performCaptureApiCall')
            ->willReturn($this->createResponseTransfer());
        $stub->method('performRefundApiCall')
            ->willReturn($this->createResponseTransfer());
        $stub->method('performCancelOrRefundApiCall')
            ->willReturn($this->createResponseTransfer());
        $stub->method('performPaymentDetailsApiCall')
            ->willReturn($this->createResponseTransfer());

        return $stub;
    }

    /**
     * @return \Generated\Shared\Transfer\AdyenApiResponseTransfer
     */
    protected function createResponseTransfer(): AdyenApiResponseTransfer
    {
        $responseTransfer = (new AdyenApiResponseBuilder([
                AdyenApiResponseTransfer::IS_SUCCESS => true,
            ]))
            ->withAnotherCancelResponse(
                [
                    AdyenApiCancelResponseTransfer::PSP_REFERENCE => static::RESPONSE_REFERENCE,
                    AdyenApiCancelResponseTransfer::RESPONSE => static::RESPONSE_CANCEL_RECEIVED,
                ],
            )
            ->withCaptureResponse(
                [
                    AdyenApiCaptureResponseTransfer::PSP_REFERENCE => static::RESPONSE_REFERENCE,
                    AdyenApiCaptureResponseTransfer::RESPONSE => static::RESPONSE_CAPTURE_RECEIVED,
                ],
            )
            ->withRefundResponse(
                [
                    AdyenApiRefundResponseTransfer::PSP_REFERENCE => static::RESPONSE_REFERENCE,
                    AdyenApiRefundResponseTransfer::RESPONSE => static::RESPONSE_REFUND_RECEIVED,
                ],
            )
            ->withCancelOrRefundResponse(
                [
                    AdyenApiCancelOrRefundResponseTransfer::PSP_REFERENCE => static::RESPONSE_REFERENCE,
                    AdyenApiCancelOrRefundResponseTransfer::RESPONSE => static::RESPONSE_CANCEL_OR_REFUND_RECEIVED,
                ],
            )
            ->withPaymentDetailsResponse(
                [
                    AdyenApiPaymentDetailsResponseTransfer::PSP_REFERENCE => static::RESPONSE_REFERENCE,
                    AdyenApiPaymentDetailsResponseTransfer::RESULT_CODE => static::RESPONSE_AUTHORISED,
                ],
            )
            ->build();

        return $responseTransfer;
    }

    /**
     * @return \SprykerEco\Zed\Adyen\Dependency\Facade\AdyenToOmsFacadeInterface
     */
    protected function createOmsFacade(): AdyenToOmsFacadeInterface
    {
        return new AdyenToOmsFacadeBridge($this->tester->getLocator()->oms()->facade());
    }

    /**
     * @return \SprykerEco\Zed\Adyen\Dependency\Service\AdyenToUtilEncodingServiceInterface
     */
    protected function createUtilEncodingService(): AdyenToUtilEncodingServiceInterface
    {
        return new AdyenToUtilEncodingServiceBridge($this->tester->getLocator()->utilEncoding()->service());
    }

    /**
     * @param string $processName
     * @param string $status
     *
     * @return \Generated\Shared\Transfer\OrderTransfer
     */
    protected function setUpCommandTest(string $processName, string $status): OrderTransfer
    {
        $this->tester->setConfig(OmsConstants::ACTIVE_PROCESSES, [$processName]);
        $this->tester->setConfig(AdyenConstants::MERCHANT_ACCOUNT, static::MERCHANT_ACCOUNT);
        $prices = [
            static::FIELD_UNIT_PRICE => static::AMOUNT,
            static::FIELD_SUM_PRICE => static::AMOUNT,
        ];
        $saveOrderTransfer = $this->tester->haveOrder($prices, $processName);

        $orderItems = $saveOrderTransfer->getOrderItems();
        foreach ($orderItems as $itemTransfer) {
            $itemTransfer->setFkSalesOrder($saveOrderTransfer->getIdSalesOrder());
        }

        $entityManager = $this->createEntityManager();
        $paymentAdyenTransfer = (new PaymentAdyenTransfer())
            ->setFkSalesOrder($saveOrderTransfer->getIdSalesOrder())
            ->setPaymentMethod($processName)
            ->setOrderReference($saveOrderTransfer->getOrderReference())
            ->setReference($this->getPaymentAdyenReference($saveOrderTransfer->getIdSalesOrder()))
            ->setPspReference($this->getPaymentAdyenPspReference($saveOrderTransfer->getIdSalesOrder()));
        $paymentAdyenTransfer = $entityManager->savePaymentAdyen($paymentAdyenTransfer);

        $paymentAdyenOrderItemTransfer = (new PaymentAdyenOrderItemTransfer())
            ->setFkPaymentAdyen($paymentAdyenTransfer->getIdPaymentAdyen())
            ->setFkSalesOrderItem($orderItems->offsetGet(0)->getIdSalesOrderItem())
            ->setStatus($status);
        $entityManager->savePaymentAdyenOrderItem($paymentAdyenOrderItemTransfer);

        $orderTransfer = (new OrderBuilder([
                OrderTransfer::ORDER_REFERENCE => $saveOrderTransfer->getOrderReference(),
                OrderTransfer::ID_SALES_ORDER => $saveOrderTransfer->getIdSalesOrder(),
                OrderTransfer::ITEMS => $orderItems,
            ]))
            ->withTotals(
                [
                    TotalsTransfer::GRAND_TOTAL => static::AMOUNT,
                    TotalsTransfer::REFUND_TOTAL => static::AMOUNT,
                ],
            )
            ->build();

        return $orderTransfer;
    }

    /**
     * @param \Generated\Shared\Transfer\OrderTransfer $orderTransfer
     *
     * @return array
     */
    protected function getSpySalesOrderItems(OrderTransfer $orderTransfer): array
    {
        $items = SpySalesOrderItemQuery::create()
            ->filterByFkSalesOrder($orderTransfer->getIdSalesOrder())
            ->find();

        return $items->getArrayCopy();
    }

    /**
     * @param \Generated\Shared\Transfer\OrderTransfer $orderTransfer
     *
     * @return \Orm\Zed\Adyen\Persistence\SpyPaymentAdyen|null
     */
    protected function findPaymentAdyen(OrderTransfer $orderTransfer): ?SpyPaymentAdyen
    {
        return SpyPaymentAdyenQuery::create()
            ->filterByOrderReference($orderTransfer->getOrderReference())
            ->findOne();
    }

    /**
     * @return \Orm\Zed\Adyen\Persistence\SpyPaymentAdyenApiLog|null
     */
    protected function findLastPaymentAdyenApiLog(): ?SpyPaymentAdyenApiLog
    {
        return SpyPaymentAdyenApiLogQuery::create()
            ->orderByIdPaymentAdyenApiLog(Criteria::DESC)
            ->findOne();
    }

    /**
     * @param \Generated\Shared\Transfer\OrderTransfer $orderTransfer
     * @param string $eventCode
     *
     * @return \Generated\Shared\Transfer\AdyenNotificationsTransfer
     */
    protected function createNotificationsTransfer(OrderTransfer $orderTransfer, string $eventCode): AdyenNotificationsTransfer
    {
        $amount = (new AdyenApiAmountBuilder([
                AdyenApiAmountTransfer::CURRENCY => static::CURRENCY,
                AdyenApiAmountTransfer::VALUE => static::AMOUNT,
            ]))
            ->build();

        $notification = (new AdyenNotificationRequestItemBuilder([
                AdyenNotificationRequestItemTransfer::PSP_REFERENCE => static::RESPONSE_REFERENCE,
                AdyenNotificationRequestItemTransfer::EVENT_CODE => $eventCode,
                AdyenNotificationRequestItemTransfer::MERCHANT_ACCOUNT_CODE => static::MERCHANT_ACCOUNT,
                AdyenNotificationRequestItemTransfer::MERCHANT_REFERENCE => $this->getPaymentAdyenReference($orderTransfer->getIdSalesOrder()),
                AdyenNotificationRequestItemTransfer::SUCCESS => static::RESPONSE_SUCCESS_TRUE,
                AdyenNotificationRequestItemTransfer::AMOUNT => $amount,
            ]))
            ->build();

        $notificationsTransfer = (new AdyenNotificationsBuilder([
                AdyenNotificationsTransfer::LIVE => false,
                AdyenNotificationsTransfer::IS_SUCCESS => static::RESPONSE_SUCCESS_TRUE,
            ]))
            ->build();

        $notificationsTransfer->addNotificationItem($notification);

        return $notificationsTransfer;
    }

    /**
     * @param \Generated\Shared\Transfer\OrderTransfer $orderTransfer
     *
     * @return \Generated\Shared\Transfer\AdyenRedirectResponseTransfer
     */
    protected function createRedirectResponseTransfer(OrderTransfer $orderTransfer): AdyenRedirectResponseTransfer
    {
        $redirectResponseTransfer = (new AdyenRedirectResponseBuilder([
                AdyenRedirectResponseTransfer::REFERENCE => $this->getPaymentAdyenReference($orderTransfer->getIdSalesOrder()),
                AdyenRedirectResponseTransfer::PAYLOAD => static::REDIRECT_RESPONSE_PAYLOAD,
                AdyenRedirectResponseTransfer::TYPE => static::REDIRECT_RESPONSE_TYPE,
                AdyenRedirectResponseTransfer::RESULT_CODE => static::REDIRECT_RESPONSE_RESULT_CODE,
            ]))
            ->build();

        return $redirectResponseTransfer;
    }

    /**
     * @param int $idSalesOrder
     *
     * @return string
     */
    protected function getPaymentAdyenReference(int $idSalesOrder): string
    {
        return sprintf('random-reference-string--%s', $idSalesOrder);
    }

    /**
     * @param int $idSalesOrder
     *
     * @return string
     */
    protected function getPaymentAdyenPspReference(int $idSalesOrder): string
    {
        return sprintf('random-psp-reference-string--%s', $idSalesOrder);
    }
}
