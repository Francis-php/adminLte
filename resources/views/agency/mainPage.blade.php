@extends('layouts.agency')
{{--@section('usermenu_body')--}}
{{--    <a class="btn btn-default btn-flat float-right  btn-block "--}}
{{--       href="{{route('agency.profile')}}" >--}}
{{--        <i class="fas fa-fw fa-user"></i>--}}
{{--        Profile--}}
{{--    </a>--}}
{{--    <a class="btn btn-default btn-flat float-right  btn-block "--}}
{{--       href="{{route('create-post')}}" >--}}
{{--        <i class="fas fa-fw fa-user"></i>--}}
{{--        Create Post--}}
{{--    </a>--}}
{{--@endsection--}}
@section('content')
    <div class="container">
        <h3>Posts</h3>
        <div class="col-12 text-center">
            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif
            @if(session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif
        </div>
        <div class="row">
            @foreach($posts as $post)
                <div class="col-md-6">
                    <div class="card mb-3">
                        <div class="card-body">
                            <h5 class="card-title">{{$post->title}}</h5>
                            <p class="card-text">{{$post->description}}</p>
                            <div class="row">
                                @foreach($post->images as $image)
                                    <div class="col-md-4">
                                        <img src="{{$image->path}}" class="img-fluid" alt="Image">
                                    </div>
                                @endforeach
                            </div><br>
                            <div class="d-flex">
                                <a href="{{route('edit-post',$post->id)}}" class="btn btn-primary mr-2">Edit</a>
                                <form action="{{route('delete-post',$post->id)}}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger">Delete</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

@endsection



