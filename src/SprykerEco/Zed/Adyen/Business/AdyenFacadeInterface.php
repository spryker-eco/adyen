<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Zed\Adyen\Business;

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
     * - Handle Authorize OMS command, make request to API, process response.
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
     * - Handle Cancel OMS command, make request to API, process response.
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
     * - Handle Capture OMS command, make request to API, process response.
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
     * - Handle Refund OMS command, make request to API, process response.
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
     * - Handle CancelOrRefund OMS command, make request to API, process response.
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
     * - Create PaymentAdyen entities, save them to DB.
     * - Update order items with necessary OMS statuses.
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
     * @api
     *
     * @param \Generated\Shared\Transfer\AdyenRedirectResponseTransfer $redirectResponseTransfer
     *
     * @return \Generated\Shared\Transfer\AdyenRedirectResponseTransfer
     */
    public function handleSofortResponseFromAdyen(AdyenRedirectResponseTransfer $redirectResponseTransfer): AdyenRedirectResponseTransfer;
}
