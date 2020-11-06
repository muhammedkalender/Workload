<?php


namespace App\Facades;

use Illuminate\Support\Facades\Facade;
use App\Contracts\Service as ServiceInterface;

class Service extends Facade
{
    /**
     * @var Service
     */
    protected static $service = null;

    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'Service';
    }

    public static function driver($driverName = ''): ServiceInterface
    {
        if (!$driverName) {
            if (!static::$service) {
                $driverName = config('services.default-provider');
            } else {
                return static::$service;
            }
        }

        static::$service = app(config('services.' . $driverName . '.class'), ['provider' => $driverName]);

        return static::$service;
    }

    public static function instance()
    {
        if (!static::$service) {
            return static::driver();
        }

        return static::$service;
    }
}
