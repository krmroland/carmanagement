<?php

namespace App\Accounts\Logs;

interface AccountDataLogger
{
    /**
     * Logs data changes
     */
    public function log(array $changes);
}
