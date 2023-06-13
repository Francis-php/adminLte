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
        <div class="card">
            <div class="card-header">
                <h3>Create new Post</h3>
            </div>
            <div class="card-body">
                <form action="{{route('store-post')}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <label for="title" class="form-label">Title</label>
                        <input type="text" class="form-control @error('title') is-invalid @enderror" id="title" name="title">
                        @error('title')
                        <div class="text-danger">{{$message}}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                        <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" rows="4"></textarea>
                        @error('description')
                        <div class="text-danger">{{$message}}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="images" class="form-label">Add Images</label>
                        <input type="file" class="form-control @error('images[]') is-invalid @enderror" id="images" name="images[]" multiple>
                        @error('images[]')
                        <div class="text-danger">{{$message}}</div>
                        @enderror
                    </div>
                    <button type="submit" class="btn btn-primary">Create Post</button>
                </form>
            </div>
        </div>
    </div>




@endsection
