<?php

/**
 * MIT License
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerEco\Zed\Adyen\Business\Hook\Mapper\MakePayment;

use Generated\Shared\Transfer\QuoteTransfer;
use SprykerEco\Shared\Adyen\AdyenSdkConfig;

class WeChatPayMapper extends AbstractMapper
{
    protected const REQUEST_TYPE = 'wechatpayWeb';

    /**
     * @return string
     */
    protected function getReturnUrl(): string
    {
        return $this->config->getWeChatPayReturnUrl();
    }

    /**
     * @param \Generated\Shared\Transfer\QuoteTransfer $quoteTransfer
     *
     * @return string[]
     */
    protected function getPayload(QuoteTransfer $quoteTransfer): array
    {
        return [
            AdyenSdkConfig::REQUEST_TYPE_FIELD => static::REQUEST_TYPE,
        ];
    }
}
