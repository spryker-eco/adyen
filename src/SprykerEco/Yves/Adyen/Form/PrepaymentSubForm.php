<?php

/**
 * MIT License
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerEco\Yves\Adyen\Form;

use Generated\Shared\Transfer\AdyenPrepaymentPaymentTransfer;
use Generated\Shared\Transfer\PaymentTransfer;
use SprykerEco\Shared\Adyen\AdyenConfig;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PrepaymentSubForm extends AbstractSubForm
{
    /**
     * @var string
     */
    protected const PAYMENT_METHOD = 'prepayment';

    /**
     * @return string
     */
    public function getName(): string
    {
        return PaymentTransfer::ADYEN_PREPAYMENT;
    }

    /**
     * @return string
     */
    public function getPropertyPath(): string
    {
        return PaymentTransfer::ADYEN_PREPAYMENT;
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
            'data_class' => AdyenPrepaymentPaymentTransfer::class,
        ])->setRequired(static::OPTIONS_FIELD_NAME);
    }
}
