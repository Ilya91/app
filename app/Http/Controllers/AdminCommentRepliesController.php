<?php

namespace App\Http\Controllers;

use App\Comment;
use App\CommentReply;
use App\Http\Requests\CommentsCreateRequest;
use Auth;
use Illuminate\Http\Request;

class AdminCommentRepliesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $replies = CommentReply::all();
        return view('admin.comments.replies.index',
            [
                'replies' => $replies
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
     *
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
        if(CommentReply::create($input)){
            return redirect()->back();
        }
    }

    public function createReply(Request $request)
    {
        return 'it is working!';
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $comment = Comment::findOrFail($id);
        $replies = $comment->replies;

        return view('admin.comments.replies.show',
            [
                'replies' => $replies
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
        $comment = CommentReply::findOrFail($id);

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
