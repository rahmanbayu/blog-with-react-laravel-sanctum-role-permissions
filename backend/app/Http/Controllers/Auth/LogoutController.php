<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LogoutController extends Controller
{
    public function __invoke()
    {
        request()->user()->tokens()->where('id', request()->user()->currentAccessToken()->id)->delete();

        return response()->json(['message' => 'You are logout.']);
    }
}
