<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Zed\Adyen\Dependency\Facade;

class AdyenToOmsFacadeBridge implements AdyenToOmsFacadeInterface
{
    /**
     * @var \Spryker\Zed\Oms\Business\OmsFacadeInterface
     */
    protected $omsFacade;

    /**
     * @param \Spryker\Zed\Oms\Business\OmsFacadeInterface $omsFacade
     */
    public function __construct($omsFacade)
    {
        $this->omsFacade = $omsFacade;
    }

    /**
     * @param string $eventId
     * @param array $orderItemIds
     * @param array $data
     *
     * @return array|null
     */
    public function triggerEventForOrderItems($eventId, array $orderItemIds, array $data = [])
    {
        return $this->omsFacade->triggerEventForOrderItems($eventId, $orderItemIds, $data);
    }
}
