<?php

/**
 * MIT License
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerEco\Zed\Adyen\Dependency\Facade;

use Generated\Shared\Transfer\AdyenApiRequestTransfer;
use Generated\Shared\Transfer\AdyenApiResponseTransfer;

class AdyenToAdyenApiFacadeBridge implements AdyenToAdyenApiFacadeInterface
{
    /**
     * @var \SprykerEco\Zed\AdyenApi\Business\AdyenApiFacadeInterface
     */
    protected $adyenApiFacade;

    /**
     * @param \SprykerEco\Zed\AdyenApi\Business\AdyenApiFacadeInterface $adyenApiFacade
     */
    public function __construct($adyenApiFacade)
    {
        $this->adyenApiFacade = $adyenApiFacade;
    }

    /**
     * @param \Generated\Shared\Transfer\AdyenApiRequestTransfer $requestTransfer
     *
     * @return \Generated\Shared\Transfer\AdyenApiResponseTransfer
     */
    public function performGetPaymentMethodsApiCall(AdyenApiRequestTransfer $requestTransfer): AdyenApiResponseTransfer
    {
        return $this->adyenApiFacade->performGetPaymentMethodsApiCall($requestTransfer);
    }

    /**
     * @param \Generated\Shared\Transfer\AdyenApiRequestTransfer $requestTransfer
     *
     * @return \Generated\Shared\Transfer\AdyenApiResponseTransfer
     */
    public function performMakePaymentApiCall(AdyenApiRequestTransfer $requestTransfer): AdyenApiResponseTransfer
    {
        return $this->adyenApiFacade->performMakePaymentApiCall($requestTransfer);
    }

    /**
     * @param \Generated\Shared\Transfer\AdyenApiRequestTransfer $requestTransfer
     *
     * @return \Generated\Shared\Transfer\AdyenApiResponseTransfer
     */
    public function performPaymentDetailsApiCall(AdyenApiRequestTransfer $requestTransfer): AdyenApiResponseTransfer
    {
        return $this->adyenApiFacade->performPaymentDetailsApiCall($requestTransfer);
    }

    /**
     * @param \Generated\Shared\Transfer\AdyenApiRequestTransfer $requestTransfer
     *
     * @return \Generated\Shared\Transfer\AdyenApiResponseTransfer
     */
    public function performAuthorizeApiCall(AdyenApiRequestTransfer $requestTransfer): AdyenApiResponseTransfer
    {
        return $this->adyenApiFacade->performAuthorizeApiCall($requestTransfer);
    }

    /**
     * @param \Generated\Shared\Transfer\AdyenApiRequestTransfer $requestTransfer
     *
     * @return \Generated\Shared\Transfer\AdyenApiResponseTransfer
     */
    public function performAuthorize3dApiCall(AdyenApiRequestTransfer $requestTransfer): AdyenApiResponseTransfer
    {
        return $this->adyenApiFacade->performAuthorize3dApiCall($requestTransfer);
    }

    /**
     * @param \Generated\Shared\Transfer\AdyenApiRequestTransfer $requestTransfer
     *
     * @return \Generated\Shared\Transfer\AdyenApiResponseTransfer
     */
    public function performCaptureApiCall(AdyenApiRequestTransfer $requestTransfer): AdyenApiResponseTransfer
    {
        return $this->adyenApiFacade->performCaptureApiCall($requestTransfer);
    }

    /**
     * @param \Generated\Shared\Transfer\AdyenApiRequestTransfer $requestTransfer
     *
     * @return \Generated\Shared\Transfer\AdyenApiResponseTransfer
     */
    public function performCancelApiCall(AdyenApiRequestTransfer $requestTransfer): AdyenApiResponseTransfer
    {
        return $this->adyenApiFacade->performCancelApiCall($requestTransfer);
    }

    /**
     * @param \Generated\Shared\Transfer\AdyenApiRequestTransfer $requestTransfer
     *
     * @return \Generated\Shared\Transfer\AdyenApiResponseTransfer
     */
    public function performRefundApiCall(AdyenApiRequestTransfer $requestTransfer): AdyenApiResponseTransfer
    {
        return $this->adyenApiFacade->performRefundApiCall($requestTransfer);
    }

    /**
     * @param \Generated\Shared\Transfer\AdyenApiRequestTransfer $requestTransfer
     *
     * @return \Generated\Shared\Transfer\AdyenApiResponseTransfer
     */
    public function performCancelOrRefundApiCall(AdyenApiRequestTransfer $requestTransfer): AdyenApiResponseTransfer
    {
        return $this->adyenApiFacade->performCancelOrRefundApiCall($requestTransfer);
    }

    /**
     * @param \Generated\Shared\Transfer\AdyenApiRequestTransfer $requestTransfer
     *
     * @return \Generated\Shared\Transfer\AdyenApiResponseTransfer
     */
    public function performTechnicalCancelApiCall(AdyenApiRequestTransfer $requestTransfer): AdyenApiResponseTransfer
    {
        return $this->adyenApiFacade->performTechnicalCancelApiCall($requestTransfer);
    }

    /**
     * @param \Generated\Shared\Transfer\AdyenApiRequestTransfer $requestTransfer
     *
     * @return \Generated\Shared\Transfer\AdyenApiResponseTransfer
     */
    public function performAdjustAuthorizationApiCall(AdyenApiRequestTransfer $requestTransfer): AdyenApiResponseTransfer
    {
        return $this->adyenApiFacade->performAdjustAuthorizationApiCall($requestTransfer);
    }
}
