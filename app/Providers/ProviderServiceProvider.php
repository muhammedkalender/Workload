<?php


namespace App\Providers;

use App\Facades\Service;
use Illuminate\Support\ServiceProvider;

class ProviderServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton('AService', function () {
            return new Service;
        }
        );
        $this->app->bind('AService', Service::class);
    }

}
