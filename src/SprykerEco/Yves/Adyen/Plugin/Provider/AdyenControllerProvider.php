<?php

/**
 * MIT License
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerEco\Yves\Adyen\Plugin\Provider;

use Silex\Application;
use Spryker\Yves\Application\Plugin\Provider\YvesControllerProvider;

class AdyenControllerProvider extends YvesControllerProvider
{
    protected const BUNDLE_NAME = 'Adyen';
    protected const CONTROLLER_NAME = 'Callback';

    /**
     * @param \Silex\Application $app
     *
     * @return void
     */
    protected function defineControllers(Application $app)
    {
        $this->createController(
            '/adyen/callback/redirect-sofort',
            'adyen-redirect-sofort',
            static::BUNDLE_NAME,
            static::CONTROLLER_NAME,
            'redirectSofort'
        );
    }
}
