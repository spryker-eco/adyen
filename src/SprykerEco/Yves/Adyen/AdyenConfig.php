<?php

/**
 * MIT License
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerEco\Yves\Adyen;

use Spryker\Yves\Kernel\AbstractBundleConfig;
use SprykerEco\Shared\Adyen\AdyenConstants;

class AdyenConfig extends AbstractBundleConfig
{
    /**
     * @api
     *
     * @return string[]
     */
    public function getSocialSecurityNumberCountriesMandatory(): array
    {
        return $this->get(AdyenConstants::SOCIAL_SECURITY_NUMBER_COUNTRIES_MANDATORY);
    }

    /**
     * @api
     *
     * @return string[]
     */
    public function getIdealIssuersList(): array
    {
        return $this->get(AdyenConstants::IDEAL_ISSUERS_LIST);
    }

    /**
     * @deprecated Will be removed without replacement. BC-reason only.
     *
     * @api
     *
     * @return string
     */
    public function getSdkCheckoutSecuredFieldsUrl(): string
    {
        return $this->get(AdyenConstants::SDK_CHECKOUT_SECURED_FIELDS_URL);
    }

    /**
     * @deprecated Will be removed without replacement. BC-reason only.
     *
     * @api
     *
     * @return string
     */
    public function getSdkCheckoutOriginKey(): string
    {
        return $this->get(AdyenConstants::SDK_CHECKOUT_ORIGIN_KEY);
    }

    /**
     * @api
     *
     * @return string
     */
    public function getSdkCheckoutShopperJsUrl(): string
    {
        return $this->get(AdyenConstants::SDK_CHECKOUT_SHOPPER_JS_URL);
    }

    /**
     * @api
     *
     * @return string
     */
    public function getSdkCheckoutShopperCssUrl(): string
    {
        return $this->get(AdyenConstants::SDK_CHECKOUT_SHOPPER_CSS_URL);
    }

    /**
     * @api
     *
     * @return string
     */
    public function getSdkCheckoutShopperJsIntegrityHash(): string
    {
        return $this->get(AdyenConstants::SDK_CHECKOUT_SHOPPER_JS_INTEGRITY_HASH);
    }

    /**
     * @api
     *
     * @return string
     */
    public function getSdkCheckoutShopperCssIntegrityHash(): string
    {
        return $this->get(AdyenConstants::SDK_CHECKOUT_SHOPPER_CSS_INTEGRITY_HASH);
    }

    /**
     * @api
     *
     * @return string
     */
    public function getSdkEnvironment(): string
    {
        return $this->get(AdyenConstants::SDK_ENVIRONMENT);
    }
}
