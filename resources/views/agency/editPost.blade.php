@extends('adminlte::page')
@section('usermenu_body')
    <a class="btn btn-default btn-flat float-right  btn-block "
       href="{{route('agency.profile')}}" >
        <i class="fas fa-fw fa-user"></i>
        Profile
    </a>
@endsection
@section('content')

    <div class="container">
        <h3>Update Post</h3>
        <form action="{{route('edit-post-information', $post->id)}}" method="POST">
            @csrf
            @method('PUT')
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
            <div class="form-group">
                <label for="title">Title</label>
                <input type="text" class="form-control @error('title') is-invalid @enderror" name="title" id="title" value="{{$post->title}}">
                @error('title')
                <div class="text-danger">{{$message}}</div>
                @enderror
            </div>
            <br>
            <div class="form-group">
                <label for="description">Description</label>
                <textarea class="form-control @error('description') is-invalid @enderror" name="description" id="description" rows="4">{{$post->description}}</textarea>
                @error('description')
                <div class="text-danger">{{$message}}</div>
                @enderror
            </div>
            <br>
            <button type="submit" class="btn btn-primary">Update Post</button>
        </form>
        <br>
        <form action="{{route('add-post-image', $post->id)}}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="images" class="form-label">Add Image</label>
                <input type="file" class="form-control @error('$image') is-invalid @enderror" name="image">
                @error('image')
                <div class="text-danger">{{$message}}</div>
                @enderror
            </div>
            <button type="submit" class="btn btn-primary">Add Image</button>
        </form>
        <br>
        <div class="row">
            @foreach($post->images as $image)
                <div class="col-md-4">
                    <div class="card mb-3">
                        <img src="{{$image->path}}" class="card-img-top" alt="Image">
                        <div class="card-body">
                            <form action="{{route('delete-post-image', $image)}}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">Delete</button>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection
