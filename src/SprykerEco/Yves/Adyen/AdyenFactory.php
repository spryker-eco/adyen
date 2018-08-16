<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Yves\Adyen;

use Spryker\Yves\Kernel\AbstractFactory;
use SprykerEco\Yves\Adyen\Form\CreditCardSubForm;
use SprykerEco\Yves\Adyen\Form\DataProvider\CreditCardFormDataProvider;
use SprykerEco\Yves\Adyen\Handler\AdyenPaymentHandler;

/**
 * @method \SprykerEco\Yves\Adyen\AdyenConfig getConfig()
 */
class AdyenFactory extends AbstractFactory
{
    public function createAdyenPaymentHandler()
    {
        return new AdyenPaymentHandler($this->getConfig());
    }

    public function createCreditCardForm()
    {
        return new CreditCardSubForm();
    }

    public function createCreditCardFormDataProvider()
    {
        return new CreditCardFormDataProvider();
    }
}
