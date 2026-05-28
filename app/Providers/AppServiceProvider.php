<?php

namespace App\Providers;

//use Illuminate\Support\Facades\Validator;

use Illuminate\Support\Facades\URL;
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
        // $this->app->bind(app\Services\HospitalTargetService::class);
        if (app()->environment('production')) {
            URL::forceScheme('https');
        }
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // Validator::extend('array_count_matches', function($attribute, $value, $parameters, $validator) {
        //     $count=count($value);
        //     $expectedCount = (int) $parameters[0];
        //      return $count===$expectedCount;
        // });//
    }
}
