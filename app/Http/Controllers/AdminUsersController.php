<?php

namespace App\Http\Controllers;

use App\Http\Requests\UsersEditRequest;
use App\Photo;
use App\Role;
use App\User;
use App\Http\Requests\UsersRequest;
use Illuminate\Support\Facades\Storage;

class AdminUsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::all();

        return view('admin.users.index',
            [
                'users' => $users
            ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $roles = Role::pluck('name', 'id')->all();
        //$roles->toArray();
        //dd($roles);
        return view('admin.users.create',
            [
                'roles' => $roles
            ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UsersRequest $request)
    {
        if(trim($request->password) == ''){
            $input = $request->except('password');
        }else{
            $input = $request->all();
        }

        if ($file = $request->file('photo_id')){
            $name = time() . $file->getClientOriginalName();
            $file->move('images', $name);

            $photo = Photo::create(['file' => $name]);

            $input['photo_id'] = $photo->id;
        }
        $input['password'] = bcrypt($request->password);
        if(User::create($input)){
            return redirect('/admin/users')->with('message', 'Пользователь был успешно создан!');
        }
        //return $request->all();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::findOrFail($id);
        $roles = Role::pluck('name', 'id')->all();
        return view('admin.users.edit',[
            'user' => $user,
            'roles' => $roles
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UsersEditRequest $request, $id)
    {

        if(trim($request->password) == ''){
            $input = $request->except('password');
        }else{
            $input = $request->all();
        }
        $user = User::findOrFail($id);

        if ($file = $request->file('photo_id')){


            if($user->photo_id){
                $path = public_path() . $user->photo->file;
                \File::delete($path);
                $name = time() . $file->getClientOriginalName();
                $file->move('images', $name);
                $photo = Photo::find($user->photo_id);
                $photo->update(['file' => $name]);
                $input['photo_id'] = $photo->id;
            }else{
                $name = time() . $file->getClientOriginalName();
                //dd($name);
                $file->move('images', $name);
                $photo = Photo::create(['file' => $name]);
                $input['photo_id'] = $photo->id;
            }
        }
        $input['password'] = bcrypt($request->password);
        if($user->update($input)){
            return redirect()->back()->with('message', 'User has updated');
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

        $user = User::find($id);
        $name = $user->name;
        $photo = Photo::find($user->photo_id);

        if($user){
            $user->delete();
        }
        if($photo){
            $path = public_path() . $photo->file;
            \File::delete($path);
            $photo->delete();
        }
        $message = 'User ' . $name . ' was daleted!';
        return redirect('/admin/users')->with('deleted_user', $message);
    }
}
