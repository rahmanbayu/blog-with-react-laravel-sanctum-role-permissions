<?php

namespace App\Http\Controllers;

use App\Http\Resources\PermissionResource;
use App\Models\Permission;
use Illuminate\Http\Request;

class PermissionController extends Controller
{
    public function index()
    {
        return Permission::paginate(5);
    }

    public function all()
    {
        return Permission::get();
    }

    public function store()
    {
        request()->validate([
            'name' => 'string|unique:permissions'
        ]);

        Permission::create(['name' => strtolower(request('name'))]);

        return  response()->json(['message' => 'Your item hasben created.']);
    }

    public function delete($id)
    {
        $permission = Permission::find($id);

        if ($permission->roles()->count()) {
            return response()->json([
                'message' => 'Your item canot be delete because related to ' . $permission->roles()->count() . ' roles.',
                'status' => false
            ]);
        }

        $permission->delete();
        return response()->json([
            'message' => 'Your item hasben deleted.',
            'status' => true
        ]);
    }

    public function update($id)
    {
        request()->validate([
            'name' => 'required|string|unique:permissions,name,' . $id
        ]);
        $permission = Permission::find($id);
        $permission->update(['name' => request('name')]);

        return response()->json(['message' => 'Your item updated.']);
    }
}
