@extends('layouts.admin')






@section('content')


    <h1>{{ $post->title }}</h1>


    <div class="row">

        <div class="col-sm-3">


            <img src="{{$post->photo ? $post->photo->file : 'http://placehold.it/400x400'}}" alt="" class="img-responsive">


        </div>



        <div class="col-sm-9">
            <ul>
                <li>Category: <b>{{ $post->category->name }}</b></li>
                <li>User: <b>{{ $post->user->name }}</b></li>
                <li>Created at: <b>{{ $post->created_at }}</b></li>
                <li>Updated at: <b>{{ $post->updated_at }}</b></li>
            </ul>


                {!! $post->body !!}


        </div>


    </div>


    <div class="row">


        @include('includes.form_error')



    </div>




@stop