<?php

namespace App\Providers;

use App\Models\Setting;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Schema;
use BezhanSalleh\FilamentLanguageSwitch\LanguageSwitch;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Only try to access settings if the table exists
        if (Schema::hasTable('settings')) {
            // Set the application name from settings
            $companyName = Setting::get('company_name');
            if ($companyName) {
                Config::set('app.name', $companyName);
            }

            // Share the company logo with all views
            View::share('companyLogo', Setting::get('company_logo'));
        }

        LanguageSwitch::configureUsing(function (LanguageSwitch $switch) {
            $switch
                ->locales(['ar','en']);
        });
    }
}
