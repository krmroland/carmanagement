<?php

namespace App\Accounts\Logs;

use Illuminate\Support\Manager;

class DataLoggerManager extends Manager
{
    /**
     * Get the default driver name.
     *
     * @return string
     */
    public function getDefaultDriver()
    {
        return env('ACCOUNT_DATA_LOG_DRIVER', 'file');
    }

    /**
     * Creates a file driver
     * @return Data Filer Logger
     */
    public function createFileDriver()
    {
        return new FileDataLogger();
    }

    /**
     * Returns  a coubase logger
     * @return \App\Accounts\Logs\CouchbaseDataLogger
     */
    public function createCouchbaseDriver()
    {
        return $this->app->make(CouchbaseDataLogger::class);
    }

    /**
     * Returns  a coubase logger
     * @return \App\Accounts\Logs\CouchbaseDataLogger
     */
    public function createArrayDriver()
    {
        return new ArrayDataLogger();
    }
}
