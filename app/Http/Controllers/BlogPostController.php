<?php

namespace App\Http\Controllers;

use App\Post;
use Illuminate\Http\Request;

class BlogPostController extends Controller
{
    public function index(){
        $posts = Post::orderBy('id', 'desc')->paginate(10);
        return view('default.index',
            [
                'posts' => $posts
            ]);
    }

    public function show($id){
        $post = Post::findOrFail($id);
        return view('default.post',
            [
                'post' => $post
            ]);
    }
}
