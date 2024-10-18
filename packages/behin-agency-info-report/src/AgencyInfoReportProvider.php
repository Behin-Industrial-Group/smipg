<?php

namespace Behin\AgencyInfoReport;

use Illuminate\Support\ServiceProvider;
use Mkhodroo\AgencyInfo\Controllers\HtmlCreatorController;

class AgencyInfoReportProvider extends ServiceProvider
{
    public function register()
    {
    }

    public function boot()
    {
        $this->publishes([
            __DIR__ . '/agency_info.php' => config_path('agency_info.php'),
        ]);
        $this->loadMigrationsFrom(__DIR__ . "/Migrations");
        $this->loadRoutesFrom(__DIR__ . '/routes.php');;
        $this->loadViewsFrom(__DIR__ . '/Views', 'AgencyReportView');
        $this->loadJsonTranslationsFrom(__DIR__ . '/Lang/');

        view()->composer('*', function ($view) {
            $view->with('HtmlCreator', HtmlCreatorController::class);
        });
    }
}
