<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Zed\Adyen\Business;

use Spryker\Zed\Kernel\Business\AbstractBusinessFactory;
use SprykerEco\Zed\Adyen\AdyenDependencyProvider;
use SprykerEco\Zed\Adyen\Business\Logger\AdyenLogger;
use SprykerEco\Zed\Adyen\Business\Logger\AdyenLoggerInterface;
use SprykerEco\Zed\Adyen\Business\Oms\Handler\AdyenCommandHandlerInterface;
use SprykerEco\Zed\Adyen\Business\Oms\Handler\AuthorizeCommandHandler;
use SprykerEco\Zed\Adyen\Business\Oms\Handler\CancelCommandHandler;
use SprykerEco\Zed\Adyen\Business\Oms\Handler\CaptureCommandHandler;
use SprykerEco\Zed\Adyen\Business\Oms\Handler\RefundCommandHandler;
use SprykerEco\Zed\Adyen\Business\Oms\Mapper\AdyenCommandMapperInterface;
use SprykerEco\Zed\Adyen\Business\Oms\Mapper\AuthorizeCommandMapper;
use SprykerEco\Zed\Adyen\Business\Oms\Mapper\CancelCommandMapper;
use SprykerEco\Zed\Adyen\Business\Oms\Mapper\CaptureCommandMapper;
use SprykerEco\Zed\Adyen\Business\Oms\Mapper\RefundCommandMapper;
use SprykerEco\Zed\Adyen\Business\Oms\Saver\AdyenCommandSaverInterface;
use SprykerEco\Zed\Adyen\Business\Oms\Saver\AuthorizeCommandSaver;
use SprykerEco\Zed\Adyen\Business\Oms\Saver\CancelCommandSaver;
use SprykerEco\Zed\Adyen\Business\Oms\Saver\CaptureCommandSaver;
use SprykerEco\Zed\Adyen\Business\Oms\Saver\RefundCommandSaver;
use SprykerEco\Zed\Adyen\Business\Payment\AdyenPaymentMethodFilter;
use SprykerEco\Zed\Adyen\Business\Payment\AdyenPaymentMethodFilterInterface;
use SprykerEco\Zed\Adyen\Dependency\Facade\AdyenToAdyenApiFacadeInterface;

/**
 * @method \SprykerEco\Zed\Adyen\AdyenConfig getConfig()
 */
class AdyenBusinessFactory extends AbstractBusinessFactory
{
    /**
     * @return \SprykerEco\Zed\Adyen\Business\Payment\AdyenPaymentMethodFilterInterface
     */
    public function createPaymentMethodsFilter(): AdyenPaymentMethodFilterInterface
    {
        return new AdyenPaymentMethodFilter($this->getAdyenApiFacade());
    }

    /**
     * @return \SprykerEco\Zed\Adyen\Business\Oms\Handler\AdyenCommandHandlerInterface
     */
    public function createAuthorizeCommandHandler(): AdyenCommandHandlerInterface
    {
        return new AuthorizeCommandHandler(
            $this->createAuthorizeCommandMapper(),
            $this->getAdyenApiFacade(),
            $this->createAuthorizeCommandSaver(),
            $this->createLogger()
        );
    }

    /**
     * @return \SprykerEco\Zed\Adyen\Business\Oms\Handler\AdyenCommandHandlerInterface
     */
    public function createCancelCommandHandler(): AdyenCommandHandlerInterface
    {
        return new CancelCommandHandler(
            $this->createCancelCommandMapper(),
            $this->getAdyenApiFacade(),
            $this->createCancelCommandSaver(),
            $this->createLogger()
        );
    }

    /**
     * @return \SprykerEco\Zed\Adyen\Business\Oms\Handler\AdyenCommandHandlerInterface
     */
    public function createCaptureCommandHandler(): AdyenCommandHandlerInterface
    {
        return new CaptureCommandHandler(
            $this->createCaptureCommandMapper(),
            $this->getAdyenApiFacade(),
            $this->createCaptureCommandSaver(),
            $this->createLogger()
        );
    }

    /**
     * @return \SprykerEco\Zed\Adyen\Business\Oms\Handler\AdyenCommandHandlerInterface
     */
    public function createRefundCommandHandler(): AdyenCommandHandlerInterface
    {
        return new RefundCommandHandler(
            $this->createRefundCommandMapper(),
            $this->getAdyenApiFacade(),
            $this->createRefundCommandSaver(),
            $this->createLogger()
        );
    }

    /**
     * @return \SprykerEco\Zed\Adyen\Business\Oms\Mapper\AdyenCommandMapperInterface
     */
    public function createAuthorizeCommandMapper(): AdyenCommandMapperInterface
    {
        return new AuthorizeCommandMapper();
    }

    /**
     * @return \SprykerEco\Zed\Adyen\Business\Oms\Mapper\AdyenCommandMapperInterface
     */
    public function createCancelCommandMapper(): AdyenCommandMapperInterface
    {
        return new CancelCommandMapper();
    }

    /**
     * @return \SprykerEco\Zed\Adyen\Business\Oms\Mapper\AdyenCommandMapperInterface
     */
    public function createCaptureCommandMapper(): AdyenCommandMapperInterface
    {
        return new CaptureCommandMapper();
    }

    /**
     * @return \SprykerEco\Zed\Adyen\Business\Oms\Mapper\AdyenCommandMapperInterface
     */
    public function createRefundCommandMapper(): AdyenCommandMapperInterface
    {
        return new RefundCommandMapper();
    }

    /**
     * @return \SprykerEco\Zed\Adyen\Business\Oms\Saver\AdyenCommandSaverInterface
     */
    public function createAuthorizeCommandSaver(): AdyenCommandSaverInterface
    {
        return new AuthorizeCommandSaver();
    }

    /**
     * @return \SprykerEco\Zed\Adyen\Business\Oms\Saver\AdyenCommandSaverInterface
     */
    public function createCancelCommandSaver(): AdyenCommandSaverInterface
    {
        return new CancelCommandSaver();
    }

    /**
     * @return \SprykerEco\Zed\Adyen\Business\Oms\Saver\AdyenCommandSaverInterface
     */
    public function createCaptureCommandSaver(): AdyenCommandSaverInterface
    {
        return new CaptureCommandSaver();
    }

    /**
     * @return \SprykerEco\Zed\Adyen\Business\Oms\Saver\AdyenCommandSaverInterface
     */
    public function createRefundCommandSaver(): AdyenCommandSaverInterface
    {
        return new RefundCommandSaver();
    }

    /**
     * @return \SprykerEco\Zed\Adyen\Business\Logger\AdyenLoggerInterface
     */
    public function createLogger(): AdyenLoggerInterface
    {
        return new AdyenLogger();
    }

    /**
     * @return \SprykerEco\Zed\Adyen\Dependency\Facade\AdyenToAdyenApiFacadeInterface
     */
    public function getAdyenApiFacade(): AdyenToAdyenApiFacadeInterface
    {
        return $this->getProvidedDependency(AdyenDependencyProvider::FACADE_ADYEN_API);
    }
}
