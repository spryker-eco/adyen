<?php

/**
 * MIT License
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerEco\Yves\Adyen\Form;

use Generated\Shared\Transfer\AdyenCreditCardPaymentTransfer;
use Generated\Shared\Transfer\PaymentTransfer;
use SprykerEco\Shared\Adyen\AdyenConfig;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;

class CreditCardSubForm extends AbstractSubForm
{
    public const SDK_CHECKOUT_SECURED_FIELDS_URL = 'sdkUrl';
    public const SDK_CHECKOUT_ORIGIN_KEY = 'sdkOriginKey';
    public const SDK_CHECKOUT_SHOPPER_JS_URL = 'sdkCheckoutShopperJsUrl';
    public const SDK_CHECKOUT_SHOPPER_CSS_URL = 'sdkCheckoutShopperCssUrl';
    public const SDK_CHECKOUT_SHOPPER_JS_INTEGRITY_HASH = 'sdkCheckoutShopperJsIntegrityHash';
    public const SDK_CHECKOUT_SHOPPER_CSS_INTEGRITY_HASH = 'sdkCheckoutShopperCssIntegrityHash';
    public const SDK_ENVIRONMENT = 'sdkEnvironment';
    public const SDK_CHECKOUT_PAYMENT_METHODS = 'sdkPaymentMethods';
    public const ENCRYPTED_CARD_NUMBER_FIELD = 'encryptedSecurityCode';
    public const ENCRYPTED_EXPIRY_YEAR_FIELD = 'encryptedCardNumber';
    public const ENCRYPTED_EXPIRY_MONTH_FIELD = 'encryptedExpiryYear';
    public const ENCRYPTED_SECURITY_CODE_FIELD = 'encryptedSecurityCode';

    protected const PAYMENT_METHOD = 'credit-card';

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

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder->add(static::ENCRYPTED_CARD_NUMBER_FIELD, HiddenType::class);

        $builder->add(static::ENCRYPTED_EXPIRY_YEAR_FIELD, HiddenType::class);

        $builder->add(static::ENCRYPTED_SECURITY_CODE_FIELD, HiddenType::class);

        $builder->add(static::ENCRYPTED_EXPIRY_MONTH_FIELD, HiddenType::class);
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
        $view->vars[static::SDK_CHECKOUT_SHOPPER_JS_URL] = $selectedOptions[static::SDK_CHECKOUT_SHOPPER_JS_URL];
        $view->vars[static::SDK_CHECKOUT_SHOPPER_CSS_URL] = $selectedOptions[static::SDK_CHECKOUT_SHOPPER_CSS_URL];
        $view->vars[static::SDK_CHECKOUT_SHOPPER_JS_INTEGRITY_HASH] = $selectedOptions[static::SDK_CHECKOUT_SHOPPER_JS_INTEGRITY_HASH];
        $view->vars[static::SDK_CHECKOUT_SHOPPER_CSS_INTEGRITY_HASH] = $selectedOptions[static::SDK_CHECKOUT_SHOPPER_CSS_INTEGRITY_HASH];
        $view->vars[static::SDK_ENVIRONMENT] = $selectedOptions[static::SDK_ENVIRONMENT];
        $view->vars[static::SDK_CHECKOUT_PAYMENT_METHODS] = $selectedOptions[static::SDK_CHECKOUT_PAYMENT_METHODS];
    }
}
