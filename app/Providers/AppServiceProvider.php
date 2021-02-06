<?php

namespace App\Providers;
use App\Models\SchoolInformation;
use Auth;
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
        view()->composer('layouts*', function ($view) {
           $school_info= SchoolInformation::first();

            $view->with(compact('school_info'));
        });
    }
}
