<?php

namespace App\Http\Controllers;

use App\Comment;
use App\Http\Requests\CommentsCreateRequest;
use App\Post;
use App\User;
use Auth;
use Illuminate\Http\Request;

class AdminCommentsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $comments = Comment::all();
        return view('admin.comments.index',
            [
                'comments' => $comments
            ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     * @param  \Illuminate\Http\Request  $id
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CommentsCreateRequest $request)
    {
        $user = Auth::user();
        $input = $request->all();
        $input['author'] = $user->name;
        $input['email'] = $user->email;
        $input['photo'] = $user->photo->file;
        //dd($input);
        if(Comment::create($input)){
            return redirect()->back();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $post = Post::findOrFail($id);
        $comments = $post->comments;
        return view('admin.comments.show',
            [
                'comments' => $comments
            ]);

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $input = $request->all();
        $comment = Comment::findOrFail($id);

        if ($comment->update($input)){
            return redirect()->back()->with('message', 'Статус комментария обновлен');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $comment = Comment::findOrFail($id);
        if($comment->delete()){
            return redirect()->back()->with('message', 'Комментарий был удалён');
        }
    }
}
