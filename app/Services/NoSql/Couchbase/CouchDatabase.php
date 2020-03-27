<?php

namespace App\Services\NoSql\Couchbase;

class CouchDatabase
{
    /**
     * The database cluster dns
     * @var string
     */
    protected $clusterDns;

    /**
     * The database authenticator
     * @var  \Couchbase\PasswordAuthenticator
     */
    protected $authenticator;

    /**
     * The database cluster
     * @var CouchbaseCluster
     */
    protected $cluster;

    /**
     * Creates an instance of this class
     */
    public function __construct(string $clusterDns)
    {
        $this->clusterDns = $clusterDns;
    }

    /**
     * Gets the current cluster
     * @return CouchbaseCluster
     */
    public function cluster()
    {
        if (!$this->cluster) {
            $this->setCluster();
        }

        return $this->cluster;
    }

    /**
     * Creates and sets an instance of a cluster
     */
    protected function setCluster()
    {
        $this->authenticator = new \Couchbase\PasswordAuthenticator();

        $this->authenticator
            ->username(env('COUCHBASE_USER_NAME'))
            ->password(env('COUCH_BASE_PASSWORD'));

        $this->cluster = new \CouchbaseCluster($this->clusterDns);

        $this->cluster->authenticate($this->authenticator);
    }
}
