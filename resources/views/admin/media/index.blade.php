@extends('layouts.admin')





@section('content')

    @if (session('message'))
        <div class="alert alert-success">
            {{ session('message') }}
        </div>
    @endif
    <h1>Media</h1>

    @if($photos)

        <table class="table">
            <thead>
            <tr>
                <th>Id</th>
                <th>Name</th>
                <th>Image</th>
                <th>Created</th>
            </tr>
            </thead>
            <tbody>


            @foreach($photos as $photo)

                <tr>
                    <td>{{$photo->id}}</td>
                    <td>{{$photo->file}}</td>
                    <td><img height="50" src="{{$photo->file ? $photo->file : 'http://placehold.it/400x400' }}" alt=""></td>
                    <td>{{$photo->created_at ? $photo->created_at : 'no date' }}</td>
                    <td>

                        {!! Form::open(['method'=>'DELETE', 'action'=> ['AdminMediaController@delete', $photo->id]]) !!}


                        <div class="form-group">
                            {!! Form::submit('Delete', ['class'=>'btn btn-danger']) !!}
                        </div>
                        {!! Form::close() !!}




                    </td>
                </tr>

            @endforeach

            </tbody>
        </table>
        <div class="row">
            <div class="col-sm-6 col-sm-offset-5">

                {{$photos->render()}}

            </div>
        </div>
    @endif

@stop