<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Yves\Adyen\Form;

use Spryker\Yves\StepEngine\Dependency\Form\AbstractSubFormType;
use Spryker\Yves\StepEngine\Dependency\Form\SubFormInterface;
use Spryker\Yves\StepEngine\Dependency\Form\SubFormProviderNameInterface;
use SprykerEco\Shared\Adyen\AdyenConfig;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\Constraints\NotBlank;

abstract class AbstractSubForm extends AbstractSubFormType implements SubFormInterface, SubFormProviderNameInterface
{
    /**
     * @return string
     */
    public function getProviderName(): string
    {
        return AdyenConfig::PROVIDER_NAME;
    }

    /**
     * @return \Symfony\Component\Validator\Constraint
     */
    protected function createNotBlankConstraint(): Constraint
    {
        return new NotBlank(['groups' => $this->getPropertyPath()]);
    }
}