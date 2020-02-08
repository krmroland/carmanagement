<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use App\Http\Controllers\Auth\RegisterController;

class UserRegistrationController extends RegisterController
{
    /**
     * The user has been registered.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  mixed  $user
     * @return mixed
     */
    protected function registered(Request $request, $user)
    {
        return Response::json([
            'message' => 'User was registered successfully',
            'user' => $user,
        ])->setStatusCode(201);
    }
}
