<?php

namespace App\Accounts\Logs;

use Illuminate\Support\Str;
use App\Services\NoSql\Couchbase\CouchDatabase;

class CouchbaseDataLogger implements AccountDataLogger
{
    /**
     * The data bucket
     * @var CouchbaseBucket|null
     */
    protected $bucket;

    /**
     * The couch database instance
     * @var \App\Services\NoSql\Couchbase\CouchDatabase
     */
    protected $couchdatabase;

    /**
     * Creates an instance of this class
     */
    public function __construct(CouchDatabase $couchdatabase)
    {
        $this->couchdatabase = $couchdatabase;
    }

    /**
     * Logs the account changes
     */
    public function log(array $changes)
    {
        $this->bucket()->upsert((string) Str::uuid(), $changes);
    }

    /**
     * Gets an instance of the account data bucket
     */
    public function bucket()
    {
        if (!$this->bucket) {
            $this->bucket = $this->couchdatabase->cluster()->openBucket('rentint-account-history');
        }
        return $this->bucket;
    }
}
