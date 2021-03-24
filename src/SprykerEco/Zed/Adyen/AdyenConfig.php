<?php

/**
 * MIT License
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerEco\Zed\Adyen;

use Spryker\Zed\Kernel\AbstractBundleConfig;
use SprykerEco\Shared\Adyen\AdyenConfig as SharedAdyenConfig;
use SprykerEco\Shared\Adyen\AdyenConstants;

class AdyenConfig extends AbstractBundleConfig
{
    protected const OMS_STATUS_NEW = 'new';
    protected const OMS_STATUS_AUTHORIZED = 'authorized';
    protected const OMS_STATUS_AUTHORIZATION_FAILED = 'authorization failed';
    protected const OMS_STATUS_CAPTURED = 'captured';
    protected const OMS_STATUS_CAPTURE_PENDING = 'capture pending';
    protected const OMS_STATUS_CAPTURE_FAILED = 'capture failed';
    protected const OMS_STATUS_CANCELED = 'canceled';
    protected const OMS_STATUS_CANCELLATION_PENDING = 'cancellation pending';
    protected const OMS_STATUS_CANCELLATION_FAILED = 'cancellation failed';
    protected const OMS_STATUS_REFUNDED = 'refunded';
    protected const OMS_STATUS_REFUND_PENDING = 'refund pending';
    protected const OMS_STATUS_REFUND_FAILED = 'refund failed';
    protected const OMS_STATUS_REFUSED = 'refused';

    protected const OMS_EVENT_CANCEL_NAME = 'cancel';
    protected const OMS_EVENT_REFUND_NAME = 'refund';

    protected const ADYEN_AUTOMATIC_OMS_TRIGGER = 'ADYEN_AUTOMATIC_OMS_TRIGGER';

    protected const ADYEN_NOTIFICATION_EVENT_CODE_AUTHORISATION = 'AUTHORISATION';
    protected const ADYEN_NOTIFICATION_EVENT_CODE_CAPTURE = 'CAPTURE';
    protected const ADYEN_NOTIFICATION_EVENT_CODE_CAPTURE_FAILED = 'CAPTURE_FAILED';
    protected const ADYEN_NOTIFICATION_EVENT_CODE_CANCELLATION = 'CANCELLATION';
    protected const ADYEN_NOTIFICATION_EVENT_CODE_REFUND = 'REFUND';
    protected const ADYEN_NOTIFICATION_EVENT_CODE_REFUND_FAILED = 'REFUND_FAILED';
    protected const ADYEN_NOTIFICATION_EVENT_CODE_REFUSED = 'REFUSED';
    protected const ADYEN_NOTIFICATION_EVENT_CODE_CANCEL_OR_REFUND = 'CANCEL_OR_REFUND';
    protected const ADYEN_NOTIFICATION_EVENT_CODE_AUTHORISATION_ADJUSTMENT = 'AUTHORISATION_ADJUSTMENT';
    protected const ADYEN_NOTIFICATION_SUCCESS_TRUE = 'true';
    protected const ADYEN_NOTIFICATION_SUCCESS_FALSE = 'false';

    protected const PAYMENT_METHOD_TYPE_PAY_PAL = 'paypal';
    protected const PAYMENT_METHOD_TYPE_SCHEME = 'scheme';
    protected const PAYMENT_METHOD_TYPE_DIRECT_E_BANKING = 'directEbanking';
    protected const PAYMENT_METHOD_TYPE_SEPA_DIRECT_DEBIT = 'sepadirectdebit';
    protected const PAYMENT_METHOD_TYPE_KLARNA = 'klarna';
    protected const PAYMENT_METHOD_TYPE_BANK_TRANSFER_IBAN = 'bankTransfer_IBAN';
    protected const PAYMENT_METHOD_TYPE_IDEAL = 'ideal';
    protected const PAYMENT_METHOD_TYPE_ALI_PAY = 'alipay';
    protected const PAYMENT_METHOD_TYPE_WE_CHAT_PAY = 'wechatpay';

    /**
     * @api
     *
     * @return string
     */
    public function getOmsStatusNew(): string
    {
        return static::OMS_STATUS_NEW;
    }

    /**
     * @api
     *
     * @return string
     */
    public function getOmsStatusAuthorized(): string
    {
        return static::OMS_STATUS_AUTHORIZED;
    }

    /**
     * @api
     *
     * @return string[]
     */
    public function getOmsStatusAuthorizedAvailableTransitions(): array
    {
        return [
            static::OMS_STATUS_NEW,
            static::OMS_STATUS_AUTHORIZATION_FAILED,
        ];
    }

    /**
     * @api
     *
     * @return string
     */
    public function getOmsStatusAuthorizationFailed(): string
    {
        return static::OMS_STATUS_AUTHORIZATION_FAILED;
    }

    /**
     * @api
     *
     * @return string
     */
    public function getOmsStatusCaptured(): string
    {
        return static::OMS_STATUS_CAPTURED;
    }

    /**
     * @api
     *
     * @return string
     */
    public function getOmsStatusCapturePending(): string
    {
        return static::OMS_STATUS_CAPTURE_PENDING;
    }

    /**
     * @api
     *
     * @return string
     */
    public function getOmsStatusCaptureFailed(): string
    {
        return static::OMS_STATUS_CAPTURE_FAILED;
    }

    /**
     * @api
     *
     * @return string
     */
    public function getOmsStatusCanceled(): string
    {
        return static::OMS_STATUS_CANCELED;
    }

    /**
     * @api
     *
     * @return string
     */
    public function getOmsStatusCancellationPending(): string
    {
        return static::OMS_STATUS_CANCELLATION_PENDING;
    }

    /**
     * @api
     *
     * @return string
     */
    public function getOmsStatusCancellationFailed(): string
    {
        return static::OMS_STATUS_CANCELLATION_FAILED;
    }

    /**
     * @api
     *
     * @return string
     */
    public function getOmsStatusRefunded(): string
    {
        return static::OMS_STATUS_REFUNDED;
    }

    /**
     * @api
     *
     * @return string
     */
    public function getOmsStatusRefundPending(): string
    {
        return static::OMS_STATUS_REFUND_PENDING;
    }

    /**
     * @api
     *
     * @return string
     */
    public function getOmsStatusRefundFailed(): string
    {
        return static::OMS_STATUS_REFUND_FAILED;
    }

    /**
     * @api
     *
     * @return string
     */
    public function getOmsStatusRefused(): string
    {
        return static::OMS_STATUS_REFUSED;
    }

    /**
     * @api
     *
     * @return string
     */
    public function getOmsEventCancelName(): string
    {
        return static::OMS_EVENT_CANCEL_NAME;
    }

    /**
     * @api
     *
     * @return string
     */
    public function getOmsEventRefundName(): string
    {
        return static::OMS_EVENT_REFUND_NAME;
    }

    /**
     * @api
     *
     * @return string
     */
    public function getMerchantAccount(): string
    {
        return $this->get(AdyenConstants::MERCHANT_ACCOUNT);
    }

    /**
     * @api
     *
     * @return string
     */
    public function getSofortReturnUrl(): string
    {
        return $this->get(AdyenConstants::SOFORT_RETURN_URL);
    }

    /**
     * @api
     *
     * @return string
     */
    public function getCreditCard3DReturnUrl(): string
    {
        return $this->get(AdyenConstants::CREDIT_CARD_3D_RETURN_URL);
    }

    /**
     * @api
     *
     * @return string
     */
    public function getIdealReturnUrl(): string
    {
        return $this->get(AdyenConstants::IDEAL_RETURN_URL);
    }

    /**
     * @api
     *
     * @return string
     */
    public function getPayPalReturnUrl(): string
    {
        return $this->get(AdyenConstants::PAY_PAL_RETURN_URL);
    }

    /**
     * @api
     *
     * @return string
     */
    public function getAliPayReturnUrl(): string
    {
        return $this->get(AdyenConstants::ALI_PAY_RETURN_URL);
    }

    /**
     * @api
     *
     * @return string
     */
    public function getWeChatPayReturnUrl(): string
    {
        return $this->get(AdyenConstants::WE_CHAT_PAY_RETURN_URL);
    }

    /**
     * Specification:
     * - Returns the klarna payment method return url.
     *
     * @api
     *
     * @return string
     */
    public function getKlarnaPayReturnUrl(): string
    {
        return $this->get(AdyenConstants::KLARNA_RETURN_URL);
    }

    /**
     * @api
     *
     * @return bool
     */
    public function isMultiplePartialCaptureEnabled(): bool
    {
        return $this->get(AdyenConstants::MULTIPLE_PARTIAL_CAPTURE_ENABLED);
    }

    /**
     * @api
     *
     * @return string
     */
    public function getAdyenAutomaticOmsTrigger(): string
    {
        return static::ADYEN_AUTOMATIC_OMS_TRIGGER;
    }

    /**
     * @api
     *
     * @return array
     */
    public function getMappedOmsStatuses(): array
    {
        return [
            static::ADYEN_NOTIFICATION_EVENT_CODE_AUTHORISATION => [
                static::ADYEN_NOTIFICATION_SUCCESS_TRUE => $this->getOmsStatusAuthorized(),
                static::ADYEN_NOTIFICATION_SUCCESS_FALSE => $this->getOmsStatusAuthorizationFailed(),
            ],
            static::ADYEN_NOTIFICATION_EVENT_CODE_CAPTURE => [
                static::ADYEN_NOTIFICATION_SUCCESS_TRUE => $this->getOmsStatusCaptured(),
                static::ADYEN_NOTIFICATION_SUCCESS_FALSE => $this->getOmsStatusCaptureFailed(),
            ],
            static::ADYEN_NOTIFICATION_EVENT_CODE_CAPTURE_FAILED => [
                static::ADYEN_NOTIFICATION_SUCCESS_TRUE => $this->getOmsStatusCaptureFailed(),
            ],
            static::ADYEN_NOTIFICATION_EVENT_CODE_CANCELLATION => [
                static::ADYEN_NOTIFICATION_SUCCESS_TRUE => $this->getOmsStatusCanceled(),
                static::ADYEN_NOTIFICATION_SUCCESS_FALSE => $this->getOmsStatusCancellationFailed(),
            ],
            static::ADYEN_NOTIFICATION_EVENT_CODE_REFUND => [
                static::ADYEN_NOTIFICATION_SUCCESS_TRUE => $this->getOmsStatusRefunded(),
                static::ADYEN_NOTIFICATION_SUCCESS_FALSE => $this->getOmsStatusRefundFailed(),
            ],
            static::ADYEN_NOTIFICATION_EVENT_CODE_REFUND_FAILED => [
                static::ADYEN_NOTIFICATION_SUCCESS_TRUE => $this->getOmsStatusRefundFailed(),
            ],
            static::ADYEN_NOTIFICATION_EVENT_CODE_REFUSED => [
                static::ADYEN_NOTIFICATION_SUCCESS_TRUE => $this->getOmsStatusRefused(),
            ],
            static::ADYEN_NOTIFICATION_EVENT_CODE_CANCEL_OR_REFUND => [
                static::ADYEN_NOTIFICATION_SUCCESS_TRUE => $this->getOmsStatusRefunded(),
                static::ADYEN_NOTIFICATION_SUCCESS_FALSE => $this->getOmsStatusRefundFailed(),
            ],
        ];
    }

    /**
     * @api
     *
     * @return string
     */
    public function getAdyenNotificationEventCodeAuthorisation(): string
    {
        return static::ADYEN_NOTIFICATION_EVENT_CODE_AUTHORISATION;
    }

    /**
     * @api
     *
     * @return bool
     */
    public function isCreditCard3dSecureEnabled(): bool
    {
        return $this->get(AdyenConstants::CREDIT_CARD_3D_SECURE_ENABLED);
    }

    /**
     * @api
     *
     * @return string
     */
    public function getRequestChannel(): string
    {
        return $this->get(AdyenConstants::REQUEST_CHANNEL);
    }

    /**
     * @api
     *
     * @return string[]
     */
    public function getMapperPaymentMethods(): array
    {
        return [
            static::PAYMENT_METHOD_TYPE_PAY_PAL => SharedAdyenConfig::ADYEN_PAY_PAL,
            static::PAYMENT_METHOD_TYPE_SCHEME => SharedAdyenConfig::ADYEN_CREDIT_CARD,
            static::PAYMENT_METHOD_TYPE_DIRECT_E_BANKING => SharedAdyenConfig::ADYEN_SOFORT,
            static::PAYMENT_METHOD_TYPE_SEPA_DIRECT_DEBIT => SharedAdyenConfig::ADYEN_DIRECT_DEBIT,
            static::PAYMENT_METHOD_TYPE_KLARNA => SharedAdyenConfig::ADYEN_KLARNA_INVOICE,
            static::PAYMENT_METHOD_TYPE_BANK_TRANSFER_IBAN => SharedAdyenConfig::ADYEN_PREPAYMENT,
            static::PAYMENT_METHOD_TYPE_IDEAL => SharedAdyenConfig::ADYEN_IDEAL,
            static::PAYMENT_METHOD_TYPE_ALI_PAY => SharedAdyenConfig::ADYEN_ALI_PAY,
            static::PAYMENT_METHOD_TYPE_WE_CHAT_PAY => SharedAdyenConfig::ADYEN_WE_CHAT_PAY,
        ];
    }
}
