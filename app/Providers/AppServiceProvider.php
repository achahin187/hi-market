<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Laravel\Passport\Http\Controllers\AccessTokenController;
class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
         Schema::defaultStringLength(191);
        view()->composer(["layouts.admin_layout","layouts.app"],function($view){
           $view->with("notifications",auth()->user()->notifications);
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
