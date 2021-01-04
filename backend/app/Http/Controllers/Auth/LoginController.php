<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    public function __invoke()
    {
        request()->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        $user = User::whereEmail(request('email'))->first();

        if (!$user || !Hash::check(request('password'), $user->password)) {
            throw ValidationException::withMessages(['email' => 'The credentials are invalid.']);
        }

        $user->tokens()->delete();
        $token = $user->createToken('web-token');

        return (new UserResource($user))->additional(['token' => $token->plainTextToken]);
    }
}
