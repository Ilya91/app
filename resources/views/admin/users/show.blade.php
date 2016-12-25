@extends('layouts.admin')

@section('content')


    <h1>{{ $user->name }}</h1>


    <div class="row">

        <div class="col-sm-3">


            <img src="{{$user->photo ? $user->photo->file : 'http://placehold.it/400x400'}}" alt="" class="img-responsive">


        </div>



        <div class="col-sm-9">
            <ul>
                <li>Role: <b>{{ $user->role->name }}</b></li>
                <li>Status: <b>{{$user->is_active == 1 ? 'Active' : 'Not Active' }}</b></li>
                <li>Email: <b>{{ $user->email }}</b></li>
                <li>Created at: <b>{{ $user->created_at }}</b></li>
                <li>Updated at: <b>{{ $user->updated_at }}</b></li>
            </ul>

        </div>


    </div>
@stop