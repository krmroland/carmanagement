<?php

namespace App\Services\NoSql;

use Illuminate\Support\ServiceProvider;
use App\Services\NoSql\Couchbase\CouchDatabase;

class NoSqlServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register()
    {
    }

    /**
     * Bootstrap services.
     */
    public function boot()
    {
        $this->app->singleton(CouchDatabase::class, function () {
            return new CouchDatabase(env('COUCHBASE_DEFAULT_CLUSTER_URL', 'couchbase://127.0.0.1'));
        });
    }
}
