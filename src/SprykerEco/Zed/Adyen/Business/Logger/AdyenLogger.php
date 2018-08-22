<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Zed\Adyen\Business\Logger;

use Generated\Shared\Transfer\AdyenApiRequestTransfer;
use Generated\Shared\Transfer\AdyenApiResponseTransfer;
use Orm\Zed\Adyen\Persistence\SpyPaymentAdyenApiLog;

class AdyenLogger implements AdyenLoggerInterface
{
    /**
     * @param string $type
     * @param \Generated\Shared\Transfer\AdyenApiRequestTransfer $request
     * @param \Generated\Shared\Transfer\AdyenApiResponseTransfer $response
     *
     * @return \Orm\Zed\Adyen\Persistence\SpyPaymentAdyenApiLog
     */
    public function log(
        string $type,
        AdyenApiRequestTransfer $request,
        AdyenApiResponseTransfer $response
    ): SpyPaymentAdyenApiLog {
        $logEntity = (new SpyPaymentAdyenApiLog())
            ->setType($type)
            ->setRequest($request->serialize())
            ->setIsSuccess($response->getIsSuccess())
            ->setResponse($response->serialize());

        if (!$response->getIsSuccess()) {
            $logEntity
                ->setStatusCode($response->getError()->getStatus())
                ->setErrorCode($response->getError()->getErrorCode())
                ->setErrorMessage($response->getError()->getMessage())
                ->setErrorType($response->getError()->getErrorType());
        }

        $logEntity->save();

        return $logEntity;
    }
}
