<?php

namespace App\Accounts\Jobs;

use Illuminate\Bus\Queueable;
use App\Accounts\Logs\DataLogger;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class RecordAccountDataChanges implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * The account data changes
     * @var array
     */
    protected $changes;

    /**
     * Create a new job instance.
     */
    public function __construct($changes)
    {
        $this->changes = $changes;
    }

    /**
     * Execute the job.
     */
    public function handle()
    {
        DataLogger::log($this->changes);
    }
}
