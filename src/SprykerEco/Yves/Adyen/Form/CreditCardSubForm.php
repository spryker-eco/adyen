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
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CreditCardSubForm extends AbstractSubForm
{
    /**
     * @deprecated Will be removed without replacement. BC-reason only.
     *
     * @var string
     */
    public const SDK_CHECKOUT_SECURED_FIELDS_URL = 'sdkUrl';

    /**
     * @var string
     */
    public const SDK_CHECKOUT_ORIGIN_KEY = 'sdkOriginKey';

    /**
     * @var string
     */
    public const SDK_CHECKOUT_SHOPPER_JS_URL = 'sdkCheckoutShopperJsUrl';

    /**
     * @var string
     */
    public const SDK_CHECKOUT_SHOPPER_CSS_URL = 'sdkCheckoutShopperCssUrl';

    /**
     * @var string
     */
    public const SDK_CHECKOUT_SHOPPER_JS_INTEGRITY_HASH = 'sdkCheckoutShopperJsIntegrityHash';

    /**
     * @var string
     */
    public const SDK_CHECKOUT_SHOPPER_CSS_INTEGRITY_HASH = 'sdkCheckoutShopperCssIntegrityHash';

    /**
     * @var string
     */
    public const SDK_ENVIRONMENT = 'sdkEnvironment';

    /**
     * @var string
     */
    public const SDK_CHECKOUT_PAYMENT_METHODS = 'sdkPaymentMethods';

    /**
     * @var string
     */
    public const ENCRYPTED_CARD_NUMBER_FIELD = 'encryptedCardNumber';

    /**
     * @var string
     */
    public const ENCRYPTED_EXPIRY_YEAR_FIELD = 'encryptedExpiryYear';

    /**
     * @var string
     */
    public const ENCRYPTED_EXPIRY_MONTH_FIELD = 'encryptedExpiryMonth';

    /**
     * @var string
     */
    public const ENCRYPTED_SECURITY_CODE_FIELD = 'encryptedSecurityCode';

    /**
     * @var string
     */
    protected const PAYMENT_METHOD = 'credit-card';

    /**
     * @var string
     */
    protected const GLOSSARY_KEY_CONSTRAINT_MESSAGE_INVALID_CARD_NUMBER = 'adyen.payment.error.cc_number';

    /**
     * @var string
     */
    protected const GLOSSARY_KEY_CONSTRAINT_MESSAGE_INVALID_EXPIRY_YEAR = 'adyen.payment.error.cc_year';

    /**
     * @var string
     */
    protected const GLOSSARY_KEY_CONSTRAINT_MESSAGE_INVALID_EXPIRY_MONTH = 'adyen.payment.error.cc_month';

    /**
     * @var string
     */
    protected const GLOSSARY_KEY_CONSTRAINT_MESSAGE_INVALID_SECURITY_CODE = 'adyen.payment.error.cc_cvv';

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
     * @param \Symfony\Component\Form\FormBuilderInterface $builder
     * @param array $options
     *
     * @return void
     */
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder->add(
            static::ENCRYPTED_CARD_NUMBER_FIELD,
            HiddenType::class,
            [
                'constraints' => [
                    $this->createNotBlankConstraint([
                        'message' => static::GLOSSARY_KEY_CONSTRAINT_MESSAGE_INVALID_CARD_NUMBER,
                    ]),
                ],
            ]
        );

        $builder->add(
            static::ENCRYPTED_EXPIRY_YEAR_FIELD,
            HiddenType::class,
            [
                'constraints' => [
                    $this->createNotBlankConstraint([
                        'message' => static::GLOSSARY_KEY_CONSTRAINT_MESSAGE_INVALID_EXPIRY_YEAR,
                    ]),
                ],
            ]
        );

        $builder->add(
            static::ENCRYPTED_EXPIRY_MONTH_FIELD,
            HiddenType::class,
            [
                'constraints' => [
                    $this->createNotBlankConstraint([
                        'message' => static::GLOSSARY_KEY_CONSTRAINT_MESSAGE_INVALID_EXPIRY_MONTH,
                    ]),
                ],
            ]
        );

        $builder->add(
            static::ENCRYPTED_SECURITY_CODE_FIELD,
            HiddenType::class,
            [
                'constraints' => [
                    $this->createNotBlankConstraint([
                        'message' => static::GLOSSARY_KEY_CONSTRAINT_MESSAGE_INVALID_SECURITY_CODE,
                    ]),
                ],
            ]
        );
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
        $view->vars[static::SDK_CHECKOUT_ORIGIN_KEY] = $selectedOptions[static::SDK_CHECKOUT_ORIGIN_KEY];
        $view->vars[static::SDK_CHECKOUT_SHOPPER_JS_URL] = $selectedOptions[static::SDK_CHECKOUT_SHOPPER_JS_URL];
        $view->vars[static::SDK_CHECKOUT_SHOPPER_CSS_URL] = $selectedOptions[static::SDK_CHECKOUT_SHOPPER_CSS_URL];
        $view->vars[static::SDK_CHECKOUT_SHOPPER_JS_INTEGRITY_HASH] = $selectedOptions[static::SDK_CHECKOUT_SHOPPER_JS_INTEGRITY_HASH];
        $view->vars[static::SDK_CHECKOUT_SHOPPER_CSS_INTEGRITY_HASH] = $selectedOptions[static::SDK_CHECKOUT_SHOPPER_CSS_INTEGRITY_HASH];
        $view->vars[static::SDK_ENVIRONMENT] = $selectedOptions[static::SDK_ENVIRONMENT];
        $view->vars[static::SDK_CHECKOUT_PAYMENT_METHODS] = $selectedOptions[static::SDK_CHECKOUT_PAYMENT_METHODS];
    }
}
