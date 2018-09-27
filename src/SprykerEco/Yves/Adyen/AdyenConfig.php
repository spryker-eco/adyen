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
     * @return string[]
     */
    public function getSocialSecurityNumberCountriesMandatory(): array
    {
        return $this->get(AdyenConstants::SOCIAL_SECURITY_NUMBER_COUNTRIES_MANDATORY);
    }
}
