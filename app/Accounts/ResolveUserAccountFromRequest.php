<?php

namespace App\Accounts;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ResolveUserAccountFromRequest
{
    /**
     * The current request
     * @var Request
     */
    protected $request;

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
        $user = Auth::user();
        // An account id could be passed through the request for organization accounts
        // todo: check if the account id exists before returning user's main account

        return $user->account;
    }
}
