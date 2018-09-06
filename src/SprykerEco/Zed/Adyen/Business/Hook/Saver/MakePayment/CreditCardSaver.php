<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Zed\Adyen\Business\Hook\Saver\MakePayment;

use Generated\Shared\Transfer\AdyenApiRequestTransfer;
use Generated\Shared\Transfer\AdyenApiResponseTransfer;

class CreditCardSaver extends AbstractSaver implements AdyenSaverInterface
{
    const MAKE_PAYMENT_CREDIT_CARD_REQUEST_TYPE = 'MakePayment[CreditCard]';

    protected function getRequestType()
    {
        return static::MAKE_PAYMENT_CREDIT_CARD_REQUEST_TYPE;
    }

    public function save(AdyenApiRequestTransfer $request, AdyenApiResponseTransfer $response)
    {
        if ($response->getIsSuccess()) {
            $this->updateEntities($request, $response);
        }

        $this->log($request, $response);
    }

    protected function updateEntities($request, $response)
    {
        $this->writer->updateOrderPaymentEntities(
            $this->config->getOmsStatusAuthorized(),
            $request,
            $response
        );
    }

}
