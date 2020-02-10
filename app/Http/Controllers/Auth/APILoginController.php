<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;

class APILoginController extends LoginController
{
    /**
     * The user has been authenticated.
     */
    protected function authenticated(Request $request, $user)
    {
        return response()->json(['message' => 'Authentication was successful', 'user' => $user]);
    }
}
