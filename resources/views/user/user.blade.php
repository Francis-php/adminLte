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
                @if($post->start_date < now())
                    <div class="col-md-4">
                        <div class="card mb-3">
                            <div class="card-body bg-opacity-75 bg-success">
                                <div class="d-flex justify-content-between"><h5 class="card-title">{{$post->title}}</h5><h5>Completed</h5></div>
                                <p>{{$post->user->name}}</p>
                                <p class="card-text">{{$post->description}}</p>
                                <p class="card-text">Price : {{$post->price}} $</p>
                                <h5>Total cost: {{$user->bookings()->where('post_id', $post->id)->first()->pivot->cost}} $</h5>
                                <h5>Tickets bought: {{$user->bookings()->where('post_id', $post->id)->first()->pivot->tickets}} $</h5>
                                <div class="d-flex justify-content-between">
                                    <p class="card-text">Start date : {{$post->start_date}} </p>
                                    <p class="card-text">End date: {{$post->end_date}} </p>
                                </div><br>

                            </div>
                        </div>
                    </div>
                @else
                <div class="col-md-4">
                    <div class="card mb-3">
                        <div class="card-body">
                            <h5 class="card-title">{{$post->title}}</h5>
                            <p>{{$post->user->name}}</p>
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
                            <hr>
                            <div class="d-flex">
                                @if($user->bookings()->where('post_id', $post->id)->exists())
                                    <form action="{{route('cancel-application', $post->id)}}" method="POST" onsubmit="return confirm('Are you sure you want to cancel the application? This action cannot be undone.');">
                                        @csrf
                                        @method('DELETE')

                                        <h5>Reserved</h5>
                                        <p>Reserved tickets: {{$user->bookings()->where('post_id', $post->id)->first()->pivot->tickets}}</p>
                                        <p>Cost: {{$user->bookings()->where('post_id', $post->id)->first()->pivot->cost}} $</p>
                                        <button class="btn btn-danger" type="submit">Cancel reservation</button>
                                        <button class="btn btn-primary change-reservation-btn" type="button" data-bs-toggle="collapse" data-bs-target="#change-reservation-{{$post->id}}" aria-expanded="false" aria-controls="change-reservation-{{$post->id}}">Change reservation</button>
                                    </form>
                                    <div class="collapse" id="change-reservation-{{$post->id}}">
                                        <form action="{{route('modify-reservation', $post->id)}}" method="POST">
                                            @csrf
                                            @method('PUT')
                                            <label for="tickets">Number of Tickets:</label>
                                            <input type="text" class="form-control @error('tickets.'.$post->id) is-invalid @enderror" name="tickets[{{$post->id}}]" value="{{$user->bookings()->where('post_id', $post->id)->first()->pivot->tickets}}" id="tickets">
                                            @error('tickets.'.$post->id)
                                            <div class="text-danger">{{$message}}</div>
                                            @enderror
                                            <br>
                                            <button class="btn btn-success" type="submit">Save</button>
                                            <button class="btn btn-secondary cancel-change-reservation" type="button" data-bs-toggle="collapse" data-bs-target="#change-reservation-{{$post->id}}" aria-expanded="false" aria-controls="change-reservation-{{$post->id}}">Cancel</button>
                                        </form>
                                    </div>
                                @else
                                    <form action="{{route('apply-post', $post->id)}}" method="POST">
                                        @csrf
                                        <label for="tickets">Number of Tickets : </label>
                                        <input type="text" class="form-control @error('tickets.'.$post->id) is-invalid @enderror" name="tickets[{{$post->id}}]" id="tickets">
                                        @error('tickets.'.$post->id)
                                        <div class="text-danger">{{$message}}</div>
                                        @enderror
                                        <br>
                                        <button class="btn btn-success" type="submit">Apply</button>
                                    </form>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                @endif
            @endforeach
        </div>
    </div>

@endsection

