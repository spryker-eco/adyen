<?php

/**
 * MIT License
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerEco\Zed\Adyen\Business;

use Generated\Shared\Transfer\AdyenNotificationsTransfer;
use Generated\Shared\Transfer\AdyenRedirectResponseTransfer;
use Generated\Shared\Transfer\CheckoutResponseTransfer;
use Generated\Shared\Transfer\OrderTransfer;
use Generated\Shared\Transfer\PaymentMethodsTransfer;
use Generated\Shared\Transfer\QuoteTransfer;
use Generated\Shared\Transfer\SaveOrderTransfer;

interface AdyenFacadeInterface
{
    /**
     * Specification:
     * - Filters available payment methods by response from Adyen GetPaymentMethods call.
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\PaymentMethodsTransfer $paymentMethodsTransfer
     * @param \Generated\Shared\Transfer\QuoteTransfer $quoteTransfer
     *
     * @return \Generated\Shared\Transfer\PaymentMethodsTransfer
     */
    public function filterPaymentMethods(
        PaymentMethodsTransfer $paymentMethodsTransfer,
        QuoteTransfer $quoteTransfer
    ): PaymentMethodsTransfer;

    /**
     * Specification:
     * - Handles Authorize OMS command, make request to API, process response.
     *
     * @api
     *
     * @param \Orm\Zed\Sales\Persistence\SpySalesOrderItem[] $orderItems
     * @param \Generated\Shared\Transfer\OrderTransfer $orderTransfer
     * @param array $data
     *
     * @return void
     */
    public function handleAuthorizeCommand(
        array $orderItems,
        OrderTransfer $orderTransfer,
        array $data
    ): void;

    /**
     * Specification:
     * - Handles Cancel OMS command, make request to API, process response.
     *
     * @api
     *
     * @param \Orm\Zed\Sales\Persistence\SpySalesOrderItem[] $orderItems
     * @param \Generated\Shared\Transfer\OrderTransfer $orderTransfer
     * @param array $data
     *
     * @return void
     */
    public function handleCancelCommand(
        array $orderItems,
        OrderTransfer $orderTransfer,
        array $data
    ): void;

    /**
     * Specification:
     * - Handles Capture OMS command, make request to API, process response.
     *
     * @api
     *
     * @param \Orm\Zed\Sales\Persistence\SpySalesOrderItem[] $orderItems
     * @param \Generated\Shared\Transfer\OrderTransfer $orderTransfer
     * @param array $data
     *
     * @return void
     */
    public function handleCaptureCommand(
        array $orderItems,
        OrderTransfer $orderTransfer,
        array $data
    ): void;

    /**
     * Specification:
     * - Handles Refund OMS command, make request to API, process response.
     *
     * @api
     *
     * @param \Orm\Zed\Sales\Persistence\SpySalesOrderItem[] $orderItems
     * @param \Generated\Shared\Transfer\OrderTransfer $orderTransfer
     * @param array $data
     *
     * @return void
     */
    public function handleRefundCommand(
        array $orderItems,
        OrderTransfer $orderTransfer,
        array $data
    ): void;

    /**
     * Specification:
     * - Handles CancelOrRefund OMS command, make request to API, process response.
     *
     * @api
     *
     * @param \Orm\Zed\Sales\Persistence\SpySalesOrderItem[] $orderItems
     * @param \Generated\Shared\Transfer\OrderTransfer $orderTransfer
     * @param array $data
     *
     * @return void
     */
    public function handleCancelOrRefundCommand(
        array $orderItems,
        OrderTransfer $orderTransfer,
        array $data
    ): void;

    /**
     * Specification:
     * - Saves order payment method data according to quote and checkout response transfer data.
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\QuoteTransfer $quoteTransfer
     * @param \Generated\Shared\Transfer\SaveOrderTransfer $saveOrderTransfer
     *
     * @return void
     */
    public function saveOrderPayment(QuoteTransfer $quoteTransfer, SaveOrderTransfer $saveOrderTransfer): void;

    /**
     * Specification:
     * - Executes make payment request to API.
     * - Creates PaymentAdyen entities, save them to DB.
     * - Updates order items with necessary OMS statuses.
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\QuoteTransfer $quoteTransfer
     * @param \Generated\Shared\Transfer\CheckoutResponseTransfer $checkoutResponse
     *
     * @return void
     */
    public function executePostSaveHook(QuoteTransfer $quoteTransfer, CheckoutResponseTransfer $checkoutResponse): void;

    /**
     * Specification:
     * - Handles response after redirect customer to the shop.
     * - Performs Payment Details call.
     * - Saves result to DB.
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\AdyenRedirectResponseTransfer $redirectResponseTransfer
     *
     * @return \Generated\Shared\Transfer\AdyenRedirectResponseTransfer
     */
    public function handleSofortResponseFromAdyen(AdyenRedirectResponseTransfer $redirectResponseTransfer): AdyenRedirectResponseTransfer;

    /**
     * Specification:
     * - Handles response after redirect customer to the shop.
     * - Performs Payment Details call.
     * - Saves result to DB.
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\AdyenRedirectResponseTransfer $redirectResponseTransfer
     *
     * @return \Generated\Shared\Transfer\AdyenRedirectResponseTransfer
     */
    public function handleCreditCard3dResponseFromAdyen(AdyenRedirectResponseTransfer $redirectResponseTransfer): AdyenRedirectResponseTransfer;

    /**
     * Specification:
     * - Handle notification from API.
     * - Update payment entities.
     * - Update order items statuses.
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\AdyenNotificationsTransfer $notificationsTransfer
     *
     * @return \Generated\Shared\Transfer\AdyenNotificationsTransfer
     */
    public function handleNotification(AdyenNotificationsTransfer $notificationsTransfer): AdyenNotificationsTransfer;
}
