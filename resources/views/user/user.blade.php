@extends('layouts.user')

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
                <div class="col-md-4">
                    <div class="card mb-3">
                        <div class="card-body">
                            <h5 class="card-title">{{$post->title}}</h5>
                            <p class="card-text">{{$post->description}}</p>
                            <p class="card-text">Price : {{$post->price}} $</p>
                            <p class="card-text">Tickets available : {{$post->tickets - $post->users()->sum('tickets')}}</p>
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
                                @if($user->bookings()->where('post_id', $post->id)->exists())
                                    <form action="{{route('cancel-application', $post->id)}}">
                                        @csrf
                                        @method('DELETE')
                                        <p>Reserved tickets: {{$user->bookings()->where('post_id', $post->id)->first()->pivot->tickets}}</p>
                                        <p>Cost: {{$user->bookings()->where('post_id', $post->id)->first()->pivot->cost}}</p>
                                        <button class="btn btn-danger" type="submit">Cancel application</button>
                                    </form>
                                @else
                                    <form action="{{route('apply-post', $post->id)}}" method="POST">
                                        @csrf
                                        <label for="tickets">Number of Tickets : </label>
                                        <input type="text" class="form-control @error('tickets') is-invalid @enderror" name="tickets" id="tickets">
                                        <button class="btn btn-success" type="submit">Apply</button>
                                    </form>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection
