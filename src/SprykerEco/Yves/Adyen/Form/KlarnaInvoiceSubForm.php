<?php

/**
 * MIT License
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerEco\Yves\Adyen\Form;

use Generated\Shared\Transfer\AdyenKlarnaInvoicePaymentTransfer;
use Generated\Shared\Transfer\PaymentTransfer;
use Spryker\Yves\StepEngine\Dependency\Form\SubFormInterface;
use SprykerEco\Shared\Adyen\AdyenConfig;
use SprykerEco\Yves\Adyen\Form\DataProvider\KlarnaInvoiceFormDataProvider;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * @method \SprykerEco\Yves\Adyen\AdyenConfig getConfig()
 */
class KlarnaInvoiceSubForm extends AbstractSubForm
{
    /**
     * @var string
     */
    protected const PAYMENT_METHOD = 'klarna-invoice';

    /**
     * @var string
     */
    protected const SELECT_OPTIONS_FIELD = 'select_options';

    /**
     * @var string
     */
    protected const SOCIAL_SECURITY_NUMBER_FIELD = 'social_security_number';

    /**
     * @var string
     */
    protected const SOCIAL_SECURITY_NUMBER_LABEL = 'Social Security Number';

    /**
     * @return string
     */
    public function getName(): string
    {
        return PaymentTransfer::ADYEN_KLARNA_INVOICE;
    }

    /**
     * @return string
     */
    public function getPropertyPath(): string
    {
        return PaymentTransfer::ADYEN_KLARNA_INVOICE;
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
            'data_class' => AdyenKlarnaInvoicePaymentTransfer::class,
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

        if ($options[static::SELECT_OPTIONS_FIELD][KlarnaInvoiceFormDataProvider::SOCIAL_SECURITY_NUMBER_REQUIRED]) {
            $this->addSocialSecurityNumber($builder);
        }
    }

    /**
     * @param \Symfony\Component\Form\FormBuilderInterface $builder
     *
     * @return \Spryker\Yves\StepEngine\Dependency\Form\SubFormInterface
     */
    protected function addSocialSecurityNumber(FormBuilderInterface $builder): SubFormInterface
    {
        $builder->add(
            static::SOCIAL_SECURITY_NUMBER_FIELD,
            TextType::class,
            [
                'label' => static::SOCIAL_SECURITY_NUMBER_LABEL,
                'required' => true,
                'constraints' => [],
            ],
        );

        return $this;
    }
}
