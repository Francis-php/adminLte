@extends('adminlte::page')

@section('usermenu_body')
    <a class="btn btn-default btn-flat float-right btn-block" href="{{ route('profile') }}">
        <i class="fas fa-fw fa-user"></i>
        Profile
    </a>
@endsection

@section('content')
    <div class="container-fluid">
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

        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">{{ $agency->name }}</h3>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="card mb-3">
                                    <div class="card-body">
                                        <h5 class="card-title">Total Posts</h5>
                                        <p class="card-text">{{ $agency->posts_count }}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="card mb-3">
                                    <div class="card-body">
                                        <h5 class="card-title">Total Earnings</h5>
                                        <p class="card-text">{{ $agency->totalEarnings }} $</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="card mb-3">
                                    <div class="card-body">
                                        <h5 class="card-title">Avg(Earning/P)</h5>
                                        <p class="card-text">{{ $agency->totalEarnings / $agency->posts_count }}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="card mb-3">
                                    <div class="card-body">
                                        <h5 class="card-title">Avg(Pricing/P)</h5>
                                        <p class="card-text">{{ $agency->posts_sum_price / $agency->posts_count }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row justify-content-center">
            <div class="col-11">
                <div class="card">
                    <div class="card-header">
                        <h3>Posts</h3>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            @foreach($agency->posts as $post)
                                <div class="col-md-4">
                                    <div class="card mb-3">
                                        <div class="card-body">
                                            <h5 class="card-title">Title: {{ $post->title }}</h5><br>
                                            <p class="card-text">Description: {{ $post->description }}</p>
                                            <p class="card-text">Price: {{ $post->price }} $</p>
                                            <p class="card-text">Total Tickets: {{ $post->tickets }}</p>
                                            <p class="card-text">Tickets Available: {{ $post->tickets - $post->users()->sum('tickets') }}</p>
                                            <div class="row">
                                                @foreach($post->images as $image)
                                                    <div class="col-md-4">
                                                        <img src="{{ $image->path }}" class="img-fluid" alt="Image">
                                                    </div>
                                                @endforeach
                                            </div>
                                            <div class="d-flex justify-content-between">
                                                <p class="card-text">Start Date: {{ $post->start_date }}</p>
                                                <p class="card-text">End Date: {{ $post->end_date }}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
