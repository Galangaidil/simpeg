<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Traits\HttpResponses;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class ApiAuthController extends Controller
{
    use HttpResponses;

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
            'device_name' => 'required',
        ]);

        $user = User::where('email', $request->email)->first();

        if (! $user || ! Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.'],
            ]);
        }

        return $this->success([
            'token' => $user->createToken($request->device_name)->plainTextToken,
            'user_name' => $user->name
        ], 'Login success', 200);
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return $this->simple("Logout success");
    }
}
