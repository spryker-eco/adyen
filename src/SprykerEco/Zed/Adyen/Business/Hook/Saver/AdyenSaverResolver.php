<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Zed\Adyen\Business\Hook\Saver;

use SprykerEco\Shared\Adyen\AdyenConfig as SharedAdyenConfig;
use SprykerEco\Zed\Adyen\AdyenConfig;
use SprykerEco\Zed\Adyen\Business\Exception\AdyenMethodSaverException;
use SprykerEco\Zed\Adyen\Business\Hook\Saver\MakePayment\AdyenSaverInterface;
use SprykerEco\Zed\Adyen\Business\Reader\AdyenReaderInterface;
use SprykerEco\Zed\Adyen\Business\Writer\AdyenWriterInterface;

class AdyenSaverResolver implements AdyenSaverResolverInterface
{
    protected const CLASS_NAME_PATTERN = '\\SprykerEco\\Zed\\Adyen\\Business\\Hook\\Saver\\MakePayment\\%sSaver';

    /**
     * @var \SprykerEco\Zed\Adyen\Business\Reader\AdyenReaderInterface
     */
    protected $reader;

    /**
     * @var \SprykerEco\Zed\Adyen\Business\Writer\AdyenWriterInterface
     */
    protected $writer;

    /**
     * @var \SprykerEco\Zed\Adyen\AdyenConfig
     */
    protected $config;

    /**
     * @param \SprykerEco\Zed\Adyen\Business\Reader\AdyenReaderInterface $reader
     * @param \SprykerEco\Zed\Adyen\Business\Writer\AdyenWriterInterface $writer
     * @param \SprykerEco\Zed\Adyen\AdyenConfig $config
     */
    public function __construct(
        AdyenReaderInterface $reader,
        AdyenWriterInterface $writer,
        AdyenConfig $config
    ) {
        $this->reader = $reader;
        $this->writer = $writer;
        $this->config = $config;
    }

    /**
     * @param string $methodName
     *
     * @throws \SprykerEco\Zed\Adyen\Business\Exception\AdyenMethodSaverException
     *
     * @return \SprykerEco\Zed\Adyen\Business\Hook\Saver\MakePayment\AdyenSaverInterface
     */
    public function resolve(string $methodName): AdyenSaverInterface
    {
        $className = $this->getMapperClassName($methodName);
        if (!class_exists($className)) {
            throw new AdyenMethodSaverException(
                sprintf('%s method saver does not exist.', $methodName)
            );
        }

        return new $className($this->reader, $this->writer, $this->config);
    }

    /**
     * @param string $methodName
     *
     * @return string
     */
    protected function getMapperClassName(string $methodName): string
    {
        return sprintf(
            static::CLASS_NAME_PATTERN,
            str_replace(strtolower(SharedAdyenConfig::PROVIDER_NAME), '', $methodName)
        );
    }
}
