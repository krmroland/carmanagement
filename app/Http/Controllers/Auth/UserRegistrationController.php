<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class UserRegistrationController extends RegisterController
{
    /**
     * The user has been registered.
     */
    protected function registered(Request $request, $user)
    {
        return Response::json([
            'message' => 'User was registered successfully',
            'user' => $user,
        ])->setStatusCode(201);
    }
}
