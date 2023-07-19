<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

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
        if($this->app->environment('production')) {
            if(empty($_SERVER["HTTPS"]) || $_SERVER["HTTPS"] !== "on")
            {
                if(!empty($_SERVER["HTTP_HOST"]) && !empty($_SERVER["REQUEST_URI"])){
                    header("Location: https://" . $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"]);
                    exit();
                }

            }
        }
    }
}
