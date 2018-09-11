<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Zed\Adyen\Business;

use Spryker\Zed\Kernel\Business\AbstractBusinessFactory;
use SprykerEco\Zed\Adyen\AdyenDependencyProvider;
use SprykerEco\Zed\Adyen\Business\Hook\AdyenHookInterface;
use SprykerEco\Zed\Adyen\Business\Hook\AdyenPostSaveHook;
use SprykerEco\Zed\Adyen\Business\Hook\Mapper\AdyenMapperResolver;
use SprykerEco\Zed\Adyen\Business\Hook\Mapper\AdyenMapperResolverInterface;
use SprykerEco\Zed\Adyen\Business\Hook\Saver\AdyenSaverResolver;
use SprykerEco\Zed\Adyen\Business\Hook\Saver\AdyenSaverResolverInterface;
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
use SprykerEco\Zed\Adyen\Business\Order\AdyenOrderPaymentManager;
use SprykerEco\Zed\Adyen\Business\Order\AdyenOrderPaymentManagerInterface;
use SprykerEco\Zed\Adyen\Business\Payment\AdyenPaymentMethodFilter;
use SprykerEco\Zed\Adyen\Business\Payment\AdyenPaymentMethodFilterInterface;
use SprykerEco\Zed\Adyen\Business\Reader\AdyenReader;
use SprykerEco\Zed\Adyen\Business\Reader\AdyenReaderInterface;
use SprykerEco\Zed\Adyen\Business\Writer\AdyenWriter;
use SprykerEco\Zed\Adyen\Business\Writer\AdyenWriterInterface;
use SprykerEco\Zed\Adyen\Dependency\Facade\AdyenToAdyenApiFacadeInterface;
use SprykerEco\Zed\Adyen\Dependency\Facade\AdyenToOmsFacadeInterface;

/**
 * @method \SprykerEco\Zed\Adyen\AdyenConfig getConfig()
 * @method \SprykerEco\Zed\Adyen\Persistence\AdyenRepositoryInterface getRepository()
 * @method \SprykerEco\Zed\Adyen\Persistence\AdyenEntityManagerInterface getEntityManager()
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
     * @return \SprykerEco\Zed\Adyen\Business\Order\AdyenOrderPaymentManagerInterface
     */
    public function createOrderPaymentManager(): AdyenOrderPaymentManagerInterface
    {
        return new AdyenOrderPaymentManager($this->createWriter());
    }

    /**
     * @return \SprykerEco\Zed\Adyen\Business\Hook\AdyenHookInterface
     */
    public function createPostCheckHook(): AdyenHookInterface
    {
        return new AdyenPostSaveHook(
            $this->getAdyenApiFacade(),
            $this->createMapperResolver(),
            $this->createSaverResolver()
        );
    }

    /**
     * @return \SprykerEco\Zed\Adyen\Business\Hook\Mapper\AdyenMapperResolverInterface
     */
    public function createMapperResolver(): AdyenMapperResolverInterface
    {
        return new AdyenMapperResolver($this->getConfig());
    }

    /**
     * @return \SprykerEco\Zed\Adyen\Business\Hook\Saver\AdyenSaverResolverInterface
     */
    public function createSaverResolver(): AdyenSaverResolverInterface
    {
        return new AdyenSaverResolver(
            $this->createReader(),
            $this->createWriter(),
            $this->getConfig()
        );
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
            $this->getConfig()
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
            $this->getConfig()
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
            $this->getConfig()
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
            $this->getConfig()
        );
    }

    /**
     * @return \SprykerEco\Zed\Adyen\Business\Oms\Mapper\AdyenCommandMapperInterface
     */
    public function createAuthorizeCommandMapper(): AdyenCommandMapperInterface
    {
        return new AuthorizeCommandMapper(
            $this->createReader(),
            $this->getConfig()
        );
    }

    /**
     * @return \SprykerEco\Zed\Adyen\Business\Oms\Mapper\AdyenCommandMapperInterface
     */
    public function createCancelCommandMapper(): AdyenCommandMapperInterface
    {
        return new CancelCommandMapper(
            $this->createReader(),
            $this->getConfig()
        );
    }

    /**
     * @return \SprykerEco\Zed\Adyen\Business\Oms\Mapper\AdyenCommandMapperInterface
     */
    public function createCaptureCommandMapper(): AdyenCommandMapperInterface
    {
        return new CaptureCommandMapper(
            $this->createReader(),
            $this->getConfig()
        );
    }

    /**
     * @return \SprykerEco\Zed\Adyen\Business\Oms\Mapper\AdyenCommandMapperInterface
     */
    public function createRefundCommandMapper(): AdyenCommandMapperInterface
    {
        return new RefundCommandMapper(
            $this->createReader(),
            $this->getConfig()
        );
    }

    /**
     * @return \SprykerEco\Zed\Adyen\Business\Oms\Saver\AdyenCommandSaverInterface
     */
    public function createAuthorizeCommandSaver(): AdyenCommandSaverInterface
    {
        return new AuthorizeCommandSaver(
            $this->getOmsFacade(),
            $this->createReader(),
            $this->createWriter(),
            $this->getConfig()
        );
    }

    /**
     * @return \SprykerEco\Zed\Adyen\Business\Oms\Saver\AdyenCommandSaverInterface
     */
    public function createCancelCommandSaver(): AdyenCommandSaverInterface
    {
        return new CancelCommandSaver(
            $this->getOmsFacade(),
            $this->createReader(),
            $this->createWriter(),
            $this->getConfig()
        );
    }

    /**
     * @return \SprykerEco\Zed\Adyen\Business\Oms\Saver\AdyenCommandSaverInterface
     */
    public function createCaptureCommandSaver(): AdyenCommandSaverInterface
    {
        return new CaptureCommandSaver(
            $this->getOmsFacade(),
            $this->createReader(),
            $this->createWriter(),
            $this->getConfig()
        );
    }

    /**
     * @return \SprykerEco\Zed\Adyen\Business\Oms\Saver\AdyenCommandSaverInterface
     */
    public function createRefundCommandSaver(): AdyenCommandSaverInterface
    {
        return new RefundCommandSaver(
            $this->getOmsFacade(),
            $this->createReader(),
            $this->createWriter(),
            $this->getConfig()
        );
    }

    /**
     * @return \SprykerEco\Zed\Adyen\Business\Logger\AdyenLoggerInterface
     */
    public function createLogger(): AdyenLoggerInterface
    {
        return new AdyenLogger($this->createWriter());
    }

    /**
     * @return \SprykerEco\Zed\Adyen\Business\Writer\AdyenWriterInterface
     */
    public function createWriter(): AdyenWriterInterface
    {
        return new AdyenWriter(
            $this->getRepository(),
            $this->getEntityManager(),
            $this->getConfig()
        );
    }

    /**
     * @return \SprykerEco\Zed\Adyen\Business\Reader\AdyenReaderInterface
     */
    public function createReader(): AdyenReaderInterface
    {
        return new AdyenReader($this->getRepository());
    }

    /**
     * @return \SprykerEco\Zed\Adyen\Dependency\Facade\AdyenToAdyenApiFacadeInterface
     */
    public function getAdyenApiFacade(): AdyenToAdyenApiFacadeInterface
    {
        return $this->getProvidedDependency(AdyenDependencyProvider::FACADE_ADYEN_API);
    }

    /**
     * @return \SprykerEco\Zed\Adyen\Dependency\Facade\AdyenToOmsFacadeInterface
     */
    public function getOmsFacade(): AdyenToOmsFacadeInterface
    {
        return $this->getProvidedDependency(AdyenDependencyProvider::FACADE_OMS);
    }
}
