<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Zed\Adyen\Persistence;

use Orm\Zed\Adyen\Persistence\SpyPaymentAdyenApiLogQuery;
use Orm\Zed\Adyen\Persistence\SpyPaymentAdyenOrderItemQuery;
use Orm\Zed\Adyen\Persistence\SpyPaymentAdyenQuery;
use Spryker\Zed\Kernel\Persistence\AbstractPersistenceFactory;

/**
 * @method \SprykerEco\Zed\Adyen\AdyenConfig getConfig()
 */
class AdyenPersistenceFactory extends AbstractPersistenceFactory
{
    /**
     * @return \Orm\Zed\Adyen\Persistence\SpyPaymentAdyenQuery
     */
    public function createPaymentAdyenQuery(): SpyPaymentAdyenQuery
    {
        return SpyPaymentAdyenQuery::create();
    }

    /**
     * @return \Orm\Zed\Adyen\Persistence\SpyPaymentAdyenApiLogQuery
     */
    public function createPaymentAdyenApiLogQuery(): SpyPaymentAdyenApiLogQuery
    {
        return SpyPaymentAdyenApiLogQuery::create();
    }

    /**
     * @return \Orm\Zed\Adyen\Persistence\SpyPaymentAdyenOrderItemQuery
     */
    public function createPaymentAdyenOrderItemQuery(): SpyPaymentAdyenOrderItemQuery
    {
        return SpyPaymentAdyenOrderItemQuery::create();
    }
}
