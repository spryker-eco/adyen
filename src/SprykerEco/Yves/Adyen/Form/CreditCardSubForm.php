<?php

/**
 * MIT License
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerEco\Yves\Adyen\Form;

use Generated\Shared\Transfer\AdyenCreditCardPaymentTransfer;
use Generated\Shared\Transfer\PaymentTransfer;
use SprykerEco\Shared\Adyen\AdyenConfig;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CreditCardSubForm extends AbstractSubForm
{
    public const SDK_CHECKOUT_SECURED_FIELDS_URL = 'sdkUrl';
    public const SDK_CHECKOUT_ORIGIN_KEY = 'sdkOriginKey';

    protected const PAYMENT_METHOD = 'credit_card';

    /**
     * @return string
     */
    public function getName(): string
    {
        return PaymentTransfer::ADYEN_CREDIT_CARD;
    }

    /**
     * @return string
     */
    public function getPropertyPath(): string
    {
        return PaymentTransfer::ADYEN_CREDIT_CARD;
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
            'data_class' => AdyenCreditCardPaymentTransfer::class,
        ])->setRequired(static::OPTIONS_FIELD_NAME);
    }

    /**
     * @param \Symfony\Component\Form\FormView $view The view
     * @param \Symfony\Component\Form\FormInterface $form The form
     * @param array $options The options
     *
     * @return void
     */
    public function buildView(FormView $view, FormInterface $form, array $options): void
    {
        parent::buildView($view, $form, $options);

        $selectedOptions = $options[static::OPTIONS_FIELD_NAME];
        $view->vars[static::SDK_CHECKOUT_SECURED_FIELDS_URL] = $selectedOptions[static::SDK_CHECKOUT_SECURED_FIELDS_URL];
        $view->vars[static::SDK_CHECKOUT_ORIGIN_KEY] = $selectedOptions[static::SDK_CHECKOUT_ORIGIN_KEY];
    }
}
