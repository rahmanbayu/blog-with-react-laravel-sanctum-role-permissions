<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        return Category::with('posts')->paginate(5);
    }

    public function all()
    {
        return Category::get();
    }

    public function create()
    {
        $data = request()->validate([
            'name' => 'required|string|unique:categories'
        ]);

        Category::create($data);

        return response()->json(['message' => 'Your item has ben created.']);
    }

    public function delete($id)
    {
        $category = Category::find($id);

        if ($category->posts()->count() > 0) {
            return response()->json([
                'message' => 'Your item canot be delete because related to ' . $category->posts()->count() . ' post.',
                'status' => false
            ]);
        }

        $category->delete();
        return response()->json([
            'message' => 'Yout item hasbed deleted!',
            'status' => true
        ]);
    }

    public function update($id)
    {
        $data = request()->validate([
            'name' => 'required|string|unique:categories,name,' . $id
        ]);

        Category::find($id)->update($data);

        return response()->json(['message' => 'Yout item hasben updated.']);
    }
}
