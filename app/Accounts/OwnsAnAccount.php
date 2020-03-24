<?php

namespace App\Accounts;

use App\Accounts\Entities\Account;
use Illuminate\Support\Facades\Date;

trait OwnsAnAccount
{
    /**
     * Hook into the Eloquent booting process
     */
    public static function bootOwnsAnAccount()
    {
        static::created(function ($model) {
            $model->account()->create(['activated_at' => Date::now()]);
        });
    }

    /**
     * The account model
     * @return MorphOne
     */
    public function account()
    {
        return $this->morphOne(Account::class, 'owner');
    }
}
