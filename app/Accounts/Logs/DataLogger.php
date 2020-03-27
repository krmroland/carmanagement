<?php

namespace App\Accounts\Logs;

use Illuminate\Support\Facades\Facade;

class DataLogger extends Facade
{
    /**
     * Get the registered name of the component.
     * @return string
     */
    public static function getFacadeAccessor()
    {
        return DataLoggerManager::class;
    }
}
