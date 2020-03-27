<?php

namespace App\Accounts;

use App\Models\BaseModel;
use App\Accounts\Entities\Account;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Date;
use App\Accounts\Jobs\RecordAccountDataChanges;

abstract class RecordsAccountDataHistoryModel extends BaseModel
{
    /**
     * The parent account
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function account()
    {
        return $this->belongsTo(Account::class);
    }

    /**
     * Hooks into the eloquent booting process
     */
    public static function boot()
    {
        parent::boot();

        foreach (['created', 'updated', 'deleted'] as $event) {
            static::$event(fn($item) => $item->recordAccountDataEvent($event));
        }
    }

    /**
     * Records account data event
     */
    public function recordAccountDataEvent($eventAction)
    {
        RecordAccountDataChanges::dispatch([
            'detail_id' => $this->getKey(),
            'detail_type' => static::class,
            'account_id' => $this->getAccountId(),
            'user_id' => Auth::id(),
            'action' => $eventAction,
            'payload' => $this->getAttributes(),
            'created_at' => Date::now()->toJson(),
        ]);
    }

    /**
     * Gets the account id
     * @return int
     */
    public function getAccountId()
    {
        return $this->account_id;
    }
}
