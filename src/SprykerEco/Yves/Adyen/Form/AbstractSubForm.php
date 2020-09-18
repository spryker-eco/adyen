<?php

/**
 * MIT License
 * For full license information, please view the LICENSE file that was distributed with this source code.
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
     * @param null|array $options
     *
     * @return \Symfony\Component\Validator\Constraint
     */
    protected function createNotBlankConstraint(?array $options): Constraint
    {
        $nonBlank = new NotBlank(['groups' => $this->getPropertyPath()]);

        if (null !== $options && is_string($options['message'])) {
            $nonBlank->message = $options['message'];
        }

        return $nonBlank;
    }
}
