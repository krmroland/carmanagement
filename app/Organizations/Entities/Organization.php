<?php

namespace App\Organizations\Entities;

use App\Models\BaseModel;
use App\Accounts\Models\Account;

class Organization extends BaseModel
{
    /**
     * The organization account
     * @return MorphTo
     */
    public function account()
    {
        return $this->morphTo(Account::class, 'ownerable');
    }
}
