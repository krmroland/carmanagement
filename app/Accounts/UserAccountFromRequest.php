<?php

namespace App\Accounts;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;

class UserAccountFromRequest
{
    /**
     * The current request
     * @var Request
     */
    protected $request;

    /**
     * The resolved account
     * @var \App\Accounts\Entities\Account|null
     */
    protected $account;

    /**
     * Creates an instance of this class
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * Fetches the users current account
     * @return \App\Accounts\Entities\Account
     */
    public function get()
    {
        if (!isset($this->account)) {
            $user = Auth::user();
            // An account id could be passed through the request for organization accounts
            // todo: check if the account id exists before returning user's main account
            $this->account = $user->account;
        }

        return $this->account;
    }

    /**
     * Determines if a given user has access to the current request account
     * @param  User $user
     * @param  Model $model
     * @param  string $key
     * @return boolean
     */
    public function userHasAccessToCurrentAccount($user, $model, $key = 'account_id')
    {
        if (!($model instanceof Model)) {
            return false;
        }

        $currentAccount = $this->get();

        return $currentAccount && $currentAccount->getKey() === $model->getAttribute($key);
    }
}
