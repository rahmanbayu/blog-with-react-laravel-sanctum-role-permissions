<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    public function __invoke()
    {
        $data = request()->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:users',
            'password' => 'required|confirmed|min:8'
        ]);
        $data['password'] = Hash::make(request('password'));

        $role  = Role::find(1);
        $role->users()->create($data);

        return response()->json(['message' => 'You are registerd please login.']);
    }
}
