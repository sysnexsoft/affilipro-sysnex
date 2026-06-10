<?php

namespace App\Providers;

use App\Models\WebSetting;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {

    }

    public function boot(): void
    {
        View::composer(['*'],function ($view){
            $view->with([
                'web_setting' => WebSetting::latest()->first(),
            ]);
        });
    }
}
