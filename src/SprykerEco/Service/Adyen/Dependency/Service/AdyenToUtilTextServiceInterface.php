<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Service\Adyen\Dependency\Service;

interface AdyenToUtilTextServiceInterface
{
    /**
     * @param string $algorithm
     * @param mixed $value
     *
     * @return string
     */
    public function hashValue($algorithm, $value);
}
