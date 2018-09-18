<?php

/**
 * MIT License
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerEco\Yves\Adyen\Form;

use Generated\Shared\Transfer\AdyenDirectDebitPaymentTransfer;
use Generated\Shared\Transfer\PaymentTransfer;
use Spryker\Yves\StepEngine\Dependency\Form\SubFormInterface;
use SprykerEco\Shared\Adyen\AdyenConfig;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DirectDebitSubForm extends AbstractSubForm
{
    protected const PAYMENT_METHOD = 'direct_debit';

    protected const OWNER_NAME_FIELD = 'owner_name';
    protected const IBAN_NUMBER_FIELD = 'iban_number';

    /**
     * @return string
     */
    public function getName(): string
    {
        return PaymentTransfer::ADYEN_DIRECT_DEBIT;
    }

    /**
     * @return string
     */
    public function getPropertyPath(): string
    {
        return PaymentTransfer::ADYEN_DIRECT_DEBIT;
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
            'data_class' => AdyenDirectDebitPaymentTransfer::class,
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
        $this->addOwnerName($builder);
        $this->addIbanNumber($builder);
    }

    /**
     * @param \Symfony\Component\Form\FormBuilderInterface $builder
     *
     * @return \Spryker\Yves\StepEngine\Dependency\Form\SubFormInterface
     */
    protected function addOwnerName(FormBuilderInterface $builder): SubFormInterface
    {
        $builder->add(
            static::OWNER_NAME_FIELD,
            TextType::class,
            [
                'label' => 'Owner Name',
                'required' => true,
                'constraints' => [],
            ]
        );

        return $this;
    }

    /**
     * @param \Symfony\Component\Form\FormBuilderInterface $builder
     *
     * @return \Spryker\Yves\StepEngine\Dependency\Form\SubFormInterface
     */
    protected function addIbanNumber(FormBuilderInterface $builder): SubFormInterface
    {
        $builder->add(
            static::IBAN_NUMBER_FIELD,
            TextType::class,
            [
                'label' => 'IBAN',
                'required' => true,
                'constraints' => [],
            ]
        );

        return $this;
    }
}
