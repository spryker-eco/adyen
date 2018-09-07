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
    protected const MAKE_PAYMENT_CREDIT_CARD_REQUEST_TYPE = 'MakePayment[CreditCard]';

    /**
     * @return string
     */
    protected function getRequestType(): string
    {
        return static::MAKE_PAYMENT_CREDIT_CARD_REQUEST_TYPE;
    }

    /**
     * @param \Generated\Shared\Transfer\AdyenApiRequestTransfer $request
     * @param \Generated\Shared\Transfer\AdyenApiResponseTransfer $response
     *
     * @return void
     */
    public function save(AdyenApiRequestTransfer $request, AdyenApiResponseTransfer $response): void
    {
        if ($response->getIsSuccess()) {
            $this->updateEntities($request, $response);
        }

        $this->log($request, $response);
    }

    /**
     * @param \Generated\Shared\Transfer\AdyenApiRequestTransfer $request
     * @param \Generated\Shared\Transfer\AdyenApiResponseTransfer $response
     *
     * @return void
     */
    protected function updateEntities(AdyenApiRequestTransfer $request, AdyenApiResponseTransfer $response): void
    {
        $this->writer->updateOrderPaymentEntities(
            $this->config->getOmsStatusAuthorized(),
            $request,
            $response
        );
    }
}
