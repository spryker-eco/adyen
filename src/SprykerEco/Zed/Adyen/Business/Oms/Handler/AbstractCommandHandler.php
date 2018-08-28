<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Zed\Adyen\Business\Oms\Handler;

use Generated\Shared\Transfer\AdyenApiRequestTransfer;
use Generated\Shared\Transfer\AdyenApiResponseTransfer;
use Generated\Shared\Transfer\OrderTransfer;
use SprykerEco\Zed\Adyen\Business\Logger\AdyenLoggerInterface;
use SprykerEco\Zed\Adyen\Business\Oms\Mapper\AdyenCommandMapperInterface;
use SprykerEco\Zed\Adyen\Business\Oms\Saver\AdyenCommandSaverInterface;
use SprykerEco\Zed\Adyen\Dependency\Facade\AdyenToAdyenApiFacadeInterface;

abstract class AbstractCommandHandler implements AdyenCommandHandlerInterface
{
    /**
     * @var \SprykerEco\Zed\Adyen\Business\Oms\Mapper\AdyenCommandMapperInterface
     */
    protected $mapper;

    /**
     * @var \SprykerEco\Zed\Adyen\Dependency\Facade\AdyenToAdyenApiFacadeInterface
     */
    protected $adyenApiFacade;

    /**
     * @var \SprykerEco\Zed\Adyen\Business\Oms\Saver\AdyenCommandSaverInterface
     */
    protected $saver;

    /**
     * @var \SprykerEco\Zed\Adyen\Business\Logger\AdyenLoggerInterface
     */
    protected $logger;

    /**
     * @param \Generated\Shared\Transfer\AdyenApiRequestTransfer $request
     *
     * @return \Generated\Shared\Transfer\AdyenApiResponseTransfer
     */
    abstract protected function sendApiRequest(AdyenApiRequestTransfer $request): AdyenApiResponseTransfer;

    /**
     * @return string
     */
    abstract protected function getRequestType(): string;

    /**
     * @param \SprykerEco\Zed\Adyen\Business\Oms\Mapper\AdyenCommandMapperInterface $mapper
     * @param \SprykerEco\Zed\Adyen\Dependency\Facade\AdyenToAdyenApiFacadeInterface $adyenApiFacade
     * @param \SprykerEco\Zed\Adyen\Business\Oms\Saver\AdyenCommandSaverInterface $saver
     * @param \SprykerEco\Zed\Adyen\Business\Logger\AdyenLoggerInterface $logger
     */
    public function __construct(
        AdyenCommandMapperInterface $mapper,
        AdyenToAdyenApiFacadeInterface $adyenApiFacade,
        AdyenCommandSaverInterface $saver,
        AdyenLoggerInterface $logger
    ) {
        $this->mapper = $mapper;
        $this->adyenApiFacade = $adyenApiFacade;
        $this->saver = $saver;
        $this->logger = $logger;
    }

    /**
     * @param \Orm\Zed\Sales\Persistence\SpySalesOrderItem[] $orderItems
     * @param \Generated\Shared\Transfer\OrderTransfer $orderTransfer
     *
     * @return void
     */
    public function handle(array $orderItems, OrderTransfer $orderTransfer): void
    {
        $request = $this->mapper->buildRequestTransfer($orderTransfer);
        $response = $this->sendApiRequest($request);
        $this->saver->save($response, $orderTransfer);
        $this->logger->log($this->getRequestType(), $request, $response);
    }
}
