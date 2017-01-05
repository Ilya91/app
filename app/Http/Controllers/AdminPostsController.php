<?php

namespace App\Http\Controllers;

use App\Category;
use App\Http\Requests\PostsCreateRequest;
use App\Http\Requests\PostsEditRequest;
use App\Photo;
use App\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Intervention\Image\Facades\Image;

class AdminPostsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = Post::orderBy('id', 'desc')->paginate(10);
        return view('admin.posts.index',
            [
                'posts' => $posts
            ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::pluck('name', 'id')->all();
        return view('admin.posts.create',
            [
                'categories' => $categories
            ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PostsCreateRequest $request)
    {
        $input = $request->all();
        $input['user_id'] = \Auth::user()->id;
        //dd($input);
        if ($file = $request->file('photo_id')){
            $name = time() . $file->getClientOriginalName();
            $file->move('images', $name);

            $photo = Photo::create(['file' => $name]);

            $input['photo_id'] = $photo->id;
        }
        if(Post::create($input)){
            return redirect('/admin/posts')->with('message', 'Пост был успешно создан!');
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($slug)
    {
        $post = Post::findBySlugOrFail($slug);
        return view('admin.posts.show',
            [
                'post' => $post
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
        $categories = Category::pluck('name', 'id')->all();
        $post = Post::findOrFail($id);
        return view('admin.posts.edit',
            [
                'post' => $post,
                'categories' => $categories
            ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(PostsEditRequest $request, $id)
    {
        $input = $request->all();
        $post = Post::findOrfail($id);
        //dd($input);
        if ($file = $request->file('photo_id')){

            if($post->photo){
                $path = public_path() . $post->photo->file;
                \File::delete($path);

                $photo = Photo::find($post->photo_id);

                $name = time() . $file->getClientOriginalName();
                $file2 = $photo->getPath() . $name;
                $img = Image::make($file);

                $img->fit(900, 300)->insert($photo->getWatermark(), 'bottom-right', 10, 10)->save($file2);
                $photo->update(['file' => $name]);
                $input['photo_id'] = $photo->id;
            }else{
                $name = time() . $file->getClientOriginalName();
                $photo = Photo::create(['file' => $name]);

                $file2 = $photo->getPath() . $name;
                $img = Image::make($file);

                $img->fit(900, 300)->insert($photo->getWatermark(), 'bottom-right', 10, 10)->save($file2);

                $input['photo_id'] = $photo->id;
            }
        }
        if($post->update($input)){
            return redirect()->back()->with('message', 'Post has updated');
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
        $post = Post::findOrFail($id);
        $photo = Photo::find($post->photo_id);

        if($post){
            $post->delete();
        }
        if($photo){
            $path = public_path() . $photo->file;
            \File::delete($path);
            $photo->delete();
        }
        $message = 'Post was daleted!';
        return redirect('/admin/posts')->with('deleted_post', $message);
    }
}
