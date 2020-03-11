<?php

namespace App\Accounts;

use Illuminate\Support\Str;
use App\Accounts\Models\Account;
use Illuminate\Support\Facades\Date;

trait HasAccount
{
    /**
     * Hook into the Eloquent booting process
     * @return void
     */
    public static function bootHasAccount()
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
        return $this->morphOne(Account::class, 'ownerable');
    }
}
