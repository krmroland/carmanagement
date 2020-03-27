<?php

namespace App\Accounts\Logs;

class ArrayDataLogger implements AccountDataLogger
{
    /**
     * The logged data
     * @var array
     */
    protected $data = [];

    /**
     * Logs the account changes
     */
    public function log(array $changes)
    {
        array_push($this->data, $changes);
    }
}
