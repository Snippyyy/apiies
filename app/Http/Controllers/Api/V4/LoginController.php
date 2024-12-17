<?php

namespace App\Http\Controllers\Api\V4;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;

class LoginController extends Controller
{
    public function __invoke(LoginRequest $request)
    {
        $request = $request->validated();

        if (!auth()->attempt($request)) {
            return response()->json([
                'message' => 'Invalid login details',
            ], 401);
        }

        if (auth()->user()->role === 'admin') {

            auth()->user()->tokens()->delete();

            return response()->json([
                'message' => 'Successfully logged in, Welcome '. auth()->user()->name,
                'token' => auth()->user()->createToken('auth_token', ['*'], now()->addHours(4))->plainTextToken,
            ]);
        }
        if (auth()->user()->role === 'user') {

            auth()->user()->tokens()->delete();

            return response()->json([
                'message' => 'Successfully logged in, Welcome '. auth()->user()->name,
                'token' => auth()->user()->createToken('auth_token', ['read'], now()->addHours(4))->plainTextToken,
            ]);
        }
        if (auth()->user()->role === 'partner') {

            auth()->user()->tokens()->delete();

            return response()->json([
                'message' => 'Successfully logged in, Welcome '. auth()->user()->name,
                'token' => auth()->user()->createToken('auth_token', ['read-write'], now()->addHours(4))->plainTextToken,
            ]);
        }



    }
}
