<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        return User::with('role')->paginate(5);
    }
    public function update($id)
    {
        request()->validate([
            'name' => 'required|string',
            'role_id' => 'required|numeric'
        ]);
        $user = User::find($id);

        $user->name = request('name');
        $user->role_id = request('role_id');
        $user->save();

        return response()->json(['message' => 'User updated.']);
    }
}
