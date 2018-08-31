<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Zed\Adyen\Business\Writer;

use Spryker\Zed\Kernel\Persistence\EntityManager\TransactionTrait;
use SprykerEco\Zed\Adyen\Persistence\AdyenEntityManagerInterface;
use SprykerEco\Zed\Adyen\Persistence\AdyenRepositoryInterface;

class AdyenWriter implements AdyenWriterInterface
{
    use TransactionTrait;

    /**
     * @var \SprykerEco\Zed\Adyen\Persistence\AdyenRepositoryInterface
     */
    protected $repository;

    /**
     * @var \SprykerEco\Zed\Adyen\Persistence\AdyenEntityManagerInterface
     */
    protected $entityManager;

    /**
     * @param \SprykerEco\Zed\Adyen\Persistence\AdyenRepositoryInterface $repository
     * @param \SprykerEco\Zed\Adyen\Persistence\AdyenEntityManagerInterface $entityManager
     */
    public function __construct(AdyenRepositoryInterface $repository, AdyenEntityManagerInterface $entityManager)
    {
        $this->repository = $repository;
        $this->entityManager = $entityManager;
    }

    /**
     * @return void
     */
    public function createPaymentEntities()
    {
    }
}
