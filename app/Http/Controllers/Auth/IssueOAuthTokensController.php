<?php

namespace App\Http\Controllers\Auth;

use App\Users\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class IssueOAuthTokensController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
            'device_name' => 'required',
            'device_id' => 'required',
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.'],
            ]);
        }

        $token = $user->createToken([
            'name' => $request->device_name,
            'device_id' => $request->device_id,
        ])->plainTextToken;

        return response()->json([
            'token' => $token,
            'user' => $user->loadMissing(['account', 'organizations.account']),
        ]);
    }
}
