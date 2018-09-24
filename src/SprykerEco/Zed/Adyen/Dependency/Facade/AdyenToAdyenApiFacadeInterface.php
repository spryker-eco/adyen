<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Zed\Adyen\Dependency\Facade;

use Generated\Shared\Transfer\AdyenApiRequestTransfer;
use Generated\Shared\Transfer\AdyenApiResponseTransfer;

interface AdyenToAdyenApiFacadeInterface
{
    /**
     * @param \Generated\Shared\Transfer\AdyenApiRequestTransfer $requestTransfer
     *
     * @return \Generated\Shared\Transfer\AdyenApiResponseTransfer
     */
    public function performGetPaymentMethodsApiCall(AdyenApiRequestTransfer $requestTransfer): AdyenApiResponseTransfer;

    /**
     * @param \Generated\Shared\Transfer\AdyenApiRequestTransfer $requestTransfer
     *
     * @return \Generated\Shared\Transfer\AdyenApiResponseTransfer
     */
    public function performMakePaymentApiCall(AdyenApiRequestTransfer $requestTransfer): AdyenApiResponseTransfer;

    /**
     * @param \Generated\Shared\Transfer\AdyenApiRequestTransfer $requestTransfer
     *
     * @return \Generated\Shared\Transfer\AdyenApiResponseTransfer
     */
    public function performPaymentsDetailsApiCall(AdyenApiRequestTransfer $requestTransfer): AdyenApiResponseTransfer;

    /**
     * @param \Generated\Shared\Transfer\AdyenApiRequestTransfer $requestTransfer
     *
     * @return \Generated\Shared\Transfer\AdyenApiResponseTransfer
     */
    public function performAuthorizeApiCall(AdyenApiRequestTransfer $requestTransfer): AdyenApiResponseTransfer;

    /**
     * @param \Generated\Shared\Transfer\AdyenApiRequestTransfer $requestTransfer
     *
     * @return \Generated\Shared\Transfer\AdyenApiResponseTransfer
     */
    public function performAuthorize3dApiCall(AdyenApiRequestTransfer $requestTransfer): AdyenApiResponseTransfer;

    /**
     * @param \Generated\Shared\Transfer\AdyenApiRequestTransfer $requestTransfer
     *
     * @return \Generated\Shared\Transfer\AdyenApiResponseTransfer
     */
    public function performCaptureApiCall(AdyenApiRequestTransfer $requestTransfer): AdyenApiResponseTransfer;

    /**
     * @param \Generated\Shared\Transfer\AdyenApiRequestTransfer $requestTransfer
     *
     * @return \Generated\Shared\Transfer\AdyenApiResponseTransfer
     */
    public function performCancelApiCall(AdyenApiRequestTransfer $requestTransfer): AdyenApiResponseTransfer;

    /**
     * @param \Generated\Shared\Transfer\AdyenApiRequestTransfer $requestTransfer
     *
     * @return \Generated\Shared\Transfer\AdyenApiResponseTransfer
     */
    public function performRefundApiCall(AdyenApiRequestTransfer $requestTransfer): AdyenApiResponseTransfer;

    /**
     * @param \Generated\Shared\Transfer\AdyenApiRequestTransfer $requestTransfer
     *
     * @return \Generated\Shared\Transfer\AdyenApiResponseTransfer
     */
    public function performCancelOrRefundApiCall(AdyenApiRequestTransfer $requestTransfer): AdyenApiResponseTransfer;

    /**
     * @param \Generated\Shared\Transfer\AdyenApiRequestTransfer $requestTransfer
     *
     * @return \Generated\Shared\Transfer\AdyenApiResponseTransfer
     */
    public function performTechnicalCancelApiCall(AdyenApiRequestTransfer $requestTransfer): AdyenApiResponseTransfer;

    /**
     * @param \Generated\Shared\Transfer\AdyenApiRequestTransfer $requestTransfer
     *
     * @return \Generated\Shared\Transfer\AdyenApiResponseTransfer
     */
    public function performAdjustAuthorizationApiCall(AdyenApiRequestTransfer $requestTransfer): AdyenApiResponseTransfer;
}
