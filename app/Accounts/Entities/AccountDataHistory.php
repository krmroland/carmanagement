<?php

namespace App\Accounts\Entities;

use App\Models\BaseModel;

class AccountDataHistory extends BaseModel
{
    /**
     * The casts array
     * @var array
     */
    protected $casts = ['payload' => 'json'];

    /**$
     * The account that owns the event
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function account()
    {
        return $this->belongsTo(Account::class);
    }
}
