<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Zed\Adyen;

use Spryker\Zed\Kernel\AbstractBundleConfig;
use SprykerEco\Shared\Adyen\AdyenConstants;

class AdyenConfig extends AbstractBundleConfig
{
    protected const OMS_STATUS_NEW = 'new';
    protected const OMS_STATUS_AUTHORIZED = 'authorized';
    protected const OMS_STATUS_CAPTURED = 'captured';
    protected const OMS_STATUS_CANCELED = 'canceled';
    protected const OMS_STATUS_REFUNDED = 'refunded';

    protected const OMS_EVENT_CANCEL_NAME = 'cancel';

    protected const ADYEN_AUTOMATIC_OMS_TRIGGER = 'ADYEN_AUTOMATIC_OMS_TRIGGER';

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
    public function getMerchantAccount(): string
    {
        return $this->get(AdyenConstants::MERCHANT_ACCOUNT);
    }

    /**
     * @return string
     */
    public function getReturnUrl(): string
    {
        return $this->get(AdyenConstants::RETURN_URL);
    }

    /**
     * @return bool
     */
    public function isMultiplePartialCaptureEnabled(): bool
    {
        return false;
    }

    /**
     * @return string
     */
    public function getAdyenAutomaticOmsTrigger(): string
    {
        return static::ADYEN_AUTOMATIC_OMS_TRIGGER;
    }
}
