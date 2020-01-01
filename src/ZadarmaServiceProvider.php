<?php

/**
 * Part of the Zadarma Laravel package.
 *
 * NOTICE OF LICENSE
 *
 * Licensed under the 3-clause BSD License.
 *
 * This source file is subject to the 3-clause BSD License that is
 * bundled with this package in the LICENSE file.
 *
 * @package    Zadarma Laravel
 * @version    1.0.0
 * @author     Jose Lorente
 * @license    BSD License (3-clause)
 * @copyright  (c) 2019, Jose Lorente
 */

namespace Jlorente\Laravel\Zadarma;

use Jlorente\Zadarma\Zadarma;
use Illuminate\Support\ServiceProvider;

/**
 * Class ZadarmaServiceProvider.
 * 
 * @author Jose Lorente <jose.lorente.martin@gmail.com>
 */
class ZadarmaServiceProvider extends ServiceProvider
{

    /**
     * @inheritdoc
     */
    protected $defer = true;

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__ . '/config/zadarma.php' => config_path('zadarma.php'),
        ]);
    }

    /**
     * {@inheritDoc}
     */
    public function register()
    {
        $this->registerZadarma();
    }

    /**
     * {@inheritDoc}
     */
    public function provides()
    {
        return [
            'zadarma'
            , Zadarma::class
        ];
    }

    /**
     * Register the Zadarma API class.
     *
     * @return void
     */
    protected function registerZadarma()
    {
        $this->app->singleton('zadarma', function ($app) {
            $config = $app['config']->get('zadarma');
            return new Zadarma(
                    isset($config['api_key']) ? $config['api_key'] : null
                    , isset($config['api_secret']) ? $config['api_secret'] : null
                    , isset($config['request_retries']) ? $config['request_retries'] : null
            );
        });

        $this->app->alias('zadarma', Zadarma::class);
    }

}
