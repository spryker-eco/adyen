<?php

/**
 * MIT License
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerEco\Yves\Adyen\Form;

use Generated\Shared\Transfer\AdyenIdealPaymentTransfer;
use Generated\Shared\Transfer\PaymentTransfer;
use SprykerEco\Shared\Adyen\AdyenConfig;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class IdealSubForm extends AbstractSubForm
{
    protected const PAYMENT_METHOD = 'ideal';
    protected const FIELD_IDEAL_ISSUER = 'idealIssuer';
    public const OPTIONS_IDEAL_ISSUER = 'OPTIONS_IDEAL_ISSUER';

    /**
     * @return string
     */
    public function getName(): string
    {
        return PaymentTransfer::ADYEN_IDEAL;
    }

    /**
     * @return string
     */
    public function getPropertyPath(): string
    {
        return PaymentTransfer::ADYEN_IDEAL;
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
            'data_class' => AdyenIdealPaymentTransfer::class,
        ])->setRequired(static::OPTIONS_FIELD_NAME);
    }

    /**
     * @param \Symfony\Component\Form\FormBuilderInterface $builder
     * @param array $options
     *
     * @return void
     */
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        parent::buildForm($builder, $options);

        $this->addIdealIssuerField($builder, $options[static::OPTIONS_FIELD_NAME][static::OPTIONS_IDEAL_ISSUER]);
    }

    /**
     * @param \Symfony\Component\Form\FormBuilderInterface $builder
     * @param array $choices
     *
     * @return $this
     */
    protected function addIdealIssuerField(FormBuilderInterface $builder, array $choices)
    {
        $builder->add(
            static::FIELD_IDEAL_ISSUER,
            ChoiceType::class,
            [
                'label' => false,
                'required' => true,
                'expanded' => false,
                'multiple' => false,
                'placeholder' => false,
                'choices' => array_flip($choices),
                'constraints' => [],
            ]
        );

        return $this;
    }
}
