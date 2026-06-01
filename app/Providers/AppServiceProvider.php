<?php

namespace App\Providers;

//use Illuminate\Support\Facades\Validator;

use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;

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


        // URL::forceScheme('https');
        // dd($test);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $isSecureRequest = (
            request()->server('HTTPS') === 'on' ||
            request()->server('HTTP_X_FORWARDED_PROTO') === 'https' ||
            request()->server('X_FORWARDED_PROTO') === 'https' ||
            request()->isSecure()
        );

        if ($isSecureRequest || Str::startsWith(config('app.url'), 'https://') || app()->environment('production')) {
            URL::forceScheme('https');
        }

        if ($isSecureRequest && config('app.url')) {
            $httpsUrl = preg_replace('/^http:/i', 'https:', config('app.url'));
            config(['app.url' => $httpsUrl]);
            URL::forceRootUrl($httpsUrl);
        }

        // Validator::extend('array_count_matches', function($attribute, $value, $parameters, $validator) {
        //     $count=count($value);
        //     $expectedCount = (int) $parameters[0];
        //      return $count===$expectedCount;
        // });//
    }
}
