@extends('layouts.agency')

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
                @if($post->start_date < now())
                    <div class="col-md-4">
                        <div class="card mb-3 bg-opacity-75 bg-success">
                            <div class="card-body">
                                <div class="d-flex justify-content-between"><h5 class="card-title">{{$post->title}}</h5> <h5>Completed</h5></div>
                                <p class="card-text">Agency : {{$post->user->name}}</p>
                                <p class="card-text">{{$post->description}}</p>
                                <p class="card-text">Price : {{$post->price}} $</p>
                                <h5>Total tickets Sold: {{$post->users()->sum('tickets')}}</h5>
                                <h5>Total Earnings : {{$post->users()->sum('tickets') * $post->price}} $</h5>
                                <div class="row">
                                </div>
                                <div class="d-flex justify-content-between">
                                    <p class="card-text">Start date : {{$post->start_date}} </p>
                                    <p class="card-text">End date: {{$post->end_date}} </p>
                                </div><br>
                                <div class="d-flex">
                                    <form action="{{route('delete-post',$post->id)}}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger">Delete</button>
                                    </form>
                                    <a href="{{route('show-applications', $post->id)}}" class="btn btn-success" style="margin-left: 20px">Applications</a>
                                </div>
                            </div>
                        </div>
                    </div>
                @else
                <div class="col-md-4">
                    <div class="card mb-3">
                        <div class="card-body">
                            <h5 class="card-title">{{$post->title}}</h5>
                            <p class="card-text">Agency : {{$post->user->name}}</p>
                            <p class="card-text">{{$post->description}}</p>
                            <p class="card-text">Price : {{$post->price}} $</p>
                            <p class="card-text">Total tickets: {{$post->tickets}}</p>
                            <p class="card-text">Available tickets: {{$post->tickets - $post->users()->sum('tickets')}}</p>
                            <div class="row">
                                @foreach($post->images as $image)
                                    <div class="col-md-4">
                                        <img src="{{$image->path}}" class="img-fluid" alt="Image">
                                    </div>
                                @endforeach
                            </div>
                            <div class="d-flex justify-content-between">
                                <p class="card-text">Start date : {{$post->start_date}} </p>
                                <p class="card-text">End date: {{$post->end_date}} </p>
                            </div><br>
                            <div class="d-flex">
                                <a href="{{route('edit-post',$post->id)}}" class="btn btn-primary" style="margin-right: 5px">Edit</a>
                                <form action="{{route('delete-post',$post->id)}}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger">Delete</button>
                                </form>
                                <a href="{{route('show-applications', $post->id)}}" class="btn btn-success" style="margin-left: 20px">Applications</a>
                            </div>

                        </div>
                    </div>
                </div>
                @endif
            @endforeach
        </div>
    </div>

@endsection



