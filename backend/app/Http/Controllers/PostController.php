<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class PostController extends Controller
{
    public function create()
    {
        $data = request()->validate([
            'title' => 'required|string:max:255|unique:posts',
            'description' => 'required|string',
            'image' => 'required|image|mimes:jpg,jpeg,png',
            'category_id' => 'required|numeric'
        ]);

        $data['image'] = request()->file('image')->store(
            'assets/posts',
            'public'
        );


        Post::create($data);

        return response()->json(['message' => 'Your item has ben created.']);
    }

    public function index()
    {
        return Post::with('category')->paginate(5);
    }

    public function all()
    {
        return Post::with('category')->with('user')->get();
    }

    public function delete($id)
    {
        $post = Post::find($id);

        File::delete(public_path('storage/' . $post->image));
        $post->delete();
        return response()->json([
            'message' => 'Your item hasben deleted.'
        ]);
    }

    public function update($id)
    {
        $data = request()->validate([
            'title' => 'required|string|unique:posts,title,' . $id,
            'description' => 'required|string',
            'image' => 'nullable|image|mimes:jpg,png,jpeg',
            'category_id' => 'required|numeric'
        ]);

        $post = Post::find($id);

        if (request('image')) {
            File::delete(public_path('storage/' . $post->image));
            $data['image'] = request()->file('image')->store(
                'assets/posts',
                'public'
            );
        }

        $post->update($data);


        return response()->json(['message' => 'Your item edited.']);
    }
}
