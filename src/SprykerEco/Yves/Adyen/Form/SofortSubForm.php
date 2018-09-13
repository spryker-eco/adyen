<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Yves\Adyen\Form;

use Generated\Shared\Transfer\AdyenCreditCardPaymentTransfer;
use Generated\Shared\Transfer\AdyenSofortPaymentTransfer;
use Generated\Shared\Transfer\PaymentTransfer;
use SprykerEco\Shared\Adyen\AdyenConfig;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SofortSubForm extends AbstractSubForm
{
    protected const PAYMENT_METHOD = 'sofort';

    /**
     * @return string
     */
    public function getName(): string
    {
        return PaymentTransfer::ADYEN_SOFORT;
    }

    /**
     * @return string
     */
    public function getPropertyPath(): string
    {
        return PaymentTransfer::ADYEN_SOFORT;
    }

    /**
     * @return string
     */
    public function getTemplatePath(): string
    {
        return AdyenConfig::PROVIDER_NAME . DIRECTORY_SEPARATOR . static::PAYMENT_METHOD;
    }

    /**
     * @param \Symfony\Component\OptionsResolver\OptionsResolver $resolver
     *
     * @return void
     */
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => AdyenSofortPaymentTransfer::class,
        ])->setRequired(static::OPTIONS_FIELD_NAME);
    }
}
