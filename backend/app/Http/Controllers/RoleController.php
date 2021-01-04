<?php

namespace App\Http\Controllers;

use App\Http\Resources\RoleResource;
use App\Models\Role;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    public function index()
    {
        return Role::with('permissions')->paginate(5);
    }
    public function all()
    {
        return Role::with('permissions')->get();
    }

    public function store()
    {
        request()->validate(['name' => 'required|string|unique:roles']);

        Role::create(['name' => strtolower(request('name'))]);

        return response()->json(['message' => 'Item created.']);
    }

    public function update($id)
    {
        request()->validate([
            'name' => 'required|string|unique:roles,name,' . $id,
            'permissions' => 'nullable|array'
        ]);

        $role = Role::find($id);

        $role->permissions()->sync(request('permissions'));

        $role->update(['name' => strtolower(request('name'))]);

        return response()->json(['message' => 'Yout item updated.']);
    }

    public function delete($id)
    {
        $role = Role::find($id);

        if ($role->users()->count()) {
            return response()->json([
                'message' => 'Yout item canot be delete because related to ' . $role->users()->count() . ' users.',
                'status' => false
            ]);
        }

        $role->permissions()->detach();
        $role->delete();

        return response()->json([
            'message' => 'Your item deleted.',
            'status' => true
        ]);
    }
}
