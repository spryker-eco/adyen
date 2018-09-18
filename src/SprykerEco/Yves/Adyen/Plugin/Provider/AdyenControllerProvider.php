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

    /**
     * @param \Silex\Application $app
     *
     * @return void
     */
    protected function defineControllers(Application $app)
    {
        $this->createController(
            '/adyen/callback',
            'callback',
            static::BUNDLE_NAME,
            'Callback',
            'index'
        );
    }
}
