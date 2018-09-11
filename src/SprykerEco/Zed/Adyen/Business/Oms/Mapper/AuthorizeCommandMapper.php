<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Zed\Adyen\Business\Oms\Mapper;

use Generated\Shared\Transfer\AdyenApiAuthorizeRequestTransfer;
use Generated\Shared\Transfer\AdyenApiRequestTransfer;
use Generated\Shared\Transfer\OrderTransfer;

class AuthorizeCommandMapper extends AbstractCommandMapper implements AdyenCommandMapperInterface
{
    /**
     * @param \Orm\Zed\Sales\Persistence\SpySalesOrderItem[] $orderItems
     * @param \Generated\Shared\Transfer\OrderTransfer $orderTransfer
     *
     * @return \Generated\Shared\Transfer\AdyenApiRequestTransfer
     */
    public function buildRequestTransfer(array $orderItems, OrderTransfer $orderTransfer): AdyenApiRequestTransfer
    {
        $request = new AdyenApiRequestTransfer();
        $paymentAdyen = $this->reader->getPaymentAdyenByOrderTransfer($orderTransfer);
        $request->setAuthorizeRequest(
            (new AdyenApiAuthorizeRequestTransfer())
        );

        return $request;
    }
}
