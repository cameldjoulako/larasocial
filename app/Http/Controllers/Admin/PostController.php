<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Post;
use App\Models\PostAttribute;

class PostController extends Controller
{
    public function index()
    {
        $posts = Post::orderBy("id", "desc")
            ->paginate();
        
        return view("admin/posts/index", [
            "posts" => $posts
        ]);
    }
}
