<?php

namespace App\Accounts\Logs;

class FileDataLogger implements AccountDataLogger
{
    /**
     * Logs the account changes
     */
    public function log(array $changes)
    {
        logger($changes);
    }
}
