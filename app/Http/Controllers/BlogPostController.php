<?php

namespace App\Http\Controllers;
use App\Comment;
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


    public function search(Request $request){
        $search = $request->input('search');
        $posts = Post::where('title','like','%'.$search.'%')->orderBy('id')->paginate(10);
        return view('default.index',
            [
                'posts' => $posts
            ]);
    }

    public function posts(){
        $posts = Post::orderBy('id', 'desc')->paginate(10);
        return view('default.posts',
            [
                'posts' => $posts
            ]);
    }

    /**
     * @param $slug
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show($slug){
        $post = Post::findBySlugOrFail($slug);
        $comments = Comment::with('children')->where('post_id', $post->id)->where('parent_id', 0)->get();
        //dd($comments);
        $post = Post::findBySlugOrFail($slug);
        return view('default.post',
            [
                'post' => $post,
                'comments' => $comments
            ]);
    }
}
