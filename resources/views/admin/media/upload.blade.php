@extends('layouts.admin')


@section('styles')

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/4.3.0/min/dropzone.min.css">


@stop




@section('content')
    <ul id="uploadedImages">

    </ul>

    <h1>Upload Media</h1>


    {!! Form::open(['method'=>'POST', 'action'=> 'AdminMediaController@store', 'class'=>'dropzone', 'id' => 'addImages']) !!}


    {!! Form::close() !!}




@stop





@section('scripts')


    <script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/4.3.0/min/dropzone.min.js"></script>
    <script src="{{asset('js/script.js')}}"></script>

@stop