<?php

/**
 * MIT License
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerEco\Zed\Adyen;

use Spryker\Zed\Kernel\AbstractBundleConfig;
use SprykerEco\Shared\Adyen\AdyenConstants;

class AdyenConfig extends AbstractBundleConfig
{
    protected const OMS_STATUS_NEW = 'new';
    protected const OMS_STATUS_AUTHORIZED_AND_CAPTURED = 'authorized and captured';
    protected const OMS_STATUS_AUTHORIZED = 'authorized';
    protected const OMS_STATUS_CAPTURED = 'captured';
    protected const OMS_STATUS_CANCELED = 'canceled';
    protected const OMS_STATUS_REFUNDED = 'refunded';

    protected const OMS_EVENT_CANCEL_NAME = 'cancel';
    protected const OMS_EVENT_REFUND_NAME = 'refund';

    protected const ADYEN_AUTOMATIC_OMS_TRIGGER = 'ADYEN_AUTOMATIC_OMS_TRIGGER';

    protected const ADYEN_NOTIFICATION_AUTHORIZE_STATUS = 'AUTHORISATION';

    /**
     * @return string
     */
    public function getOmsStatusNew(): string
    {
        return static::OMS_STATUS_NEW;
    }

    /**
     * @return string
     */
    public function getOmsStatusAuthorizedAndCaptured(): string
    {
        return static::OMS_STATUS_AUTHORIZED_AND_CAPTURED;
    }

    /**
     * @return string
     */
    public function getOmsStatusAuthorized(): string
    {
        return static::OMS_STATUS_AUTHORIZED;
    }

    /**
     * @return string
     */
    public function getOmsStatusCaptured(): string
    {
        return static::OMS_STATUS_CAPTURED;
    }

    /**
     * @return string
     */
    public function getOmsStatusCanceled(): string
    {
        return static::OMS_STATUS_CANCELED;
    }

    /**
     * @return string
     */
    public function getOmsStatusRefunded(): string
    {
        return static::OMS_STATUS_REFUNDED;
    }

    /**
     * @return string
     */
    public function getOmsEventCancelName(): string
    {
        return static::OMS_EVENT_CANCEL_NAME;
    }

    /**
     * @return string
     */
    public function getOmsEventRefundName(): string
    {
        return static::OMS_EVENT_REFUND_NAME;
    }

    /**
     * @return string
     */
    public function getMerchantAccount(): string
    {
        return $this->get(AdyenConstants::MERCHANT_ACCOUNT);
    }

    /**
     * @return string
     */
    public function getSofortReturnUrl(): string
    {
        return $this->get(AdyenConstants::SOFORT_RETURN_URL);
    }

    /**
     * @return string
     */
    public function getCreditCard3DReturnUrl(): string
    {
        return $this->get(AdyenConstants::CREDIT_CARD_3D_RETURN_URL);
    }

    /**
     * @return string
     */
    public function getIdealReturnUrl(): string
    {
        return $this->get(AdyenConstants::IDEAL_RETURN_URL);
    }

    /**
     * @return string
     */
    public function getPayPalReturnUrl(): string
    {
        return $this->get(AdyenConstants::PAY_PAL_RETURN_URL);
    }

    /**
     * @return bool
     */
    public function isMultiplePartialCaptureEnabled(): bool
    {
        return $this->get(AdyenConstants::MULTIPLE_PARTIAL_CAPTURE_ENABLED);
    }

    /**
     * @return string
     */
    public function getAdyenAutomaticOmsTrigger(): string
    {
        return static::ADYEN_AUTOMATIC_OMS_TRIGGER;
    }

    /**
     * @return string[]
     */
    public function getMappedOmsStatuses(): array
    {
        return [
            static::ADYEN_NOTIFICATION_AUTHORIZE_STATUS => $this->getOmsStatusAuthorized(),
        ];
    }

    /**
     * @return bool
     */
    public function isCreditCard3dSecureEnabled(): bool
    {
        return $this->get(AdyenConstants::CREDIT_CARD_3D_SECURE_ENABLED);
    }
}
