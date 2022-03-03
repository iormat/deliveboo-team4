<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Braintree\Gateway;


class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->app->singleton(Gateway::class, function($app){
            return new Gateway(
                [
                    'environment'   => 'sandbox',
                    'merchantId'    => "xsb6y9g4jtz49jnm",
                    'publicKey'     => "xgq57st8ks9mx5nv",
                    'privateKey'    => "d381a6f90d469881b087dc4bc9b159d2",
                ]
            );
        });
    }
}