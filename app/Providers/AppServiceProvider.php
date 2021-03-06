<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Schema;
use Laravel\Dusk\DuskServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //validate if phone number start with '01'
        Validator::extend('phone_number', function ($attribute, $value, $parameters) {
            return substr($value, 0, 2) == '01';
        });
        
        //validate if address consist of only letters, numbers nad spaces
        Validator::extend('alpha_num_space', function ($attribute, $value, $parameters) {
            return preg_match('/^[a-z0-9 .\-]+$/i', $value);
        });
        
        Schema::defaultStringLength(191);
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        if ($this->app->environment('local', 'testing', 'staging')) {
            $this->app->register(DuskServiceProvider::class);
        }
    }
}
