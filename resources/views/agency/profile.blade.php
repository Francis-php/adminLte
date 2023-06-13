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
        <div class="main-body">

            <nav aria-label="breadcrumb" class="main-breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{route('agency.main_page')}}">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Edit Profile</li>
                </ol>
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
            </nav>
            <div class="row gutters-sm">
                <div class="col-md-4">
                    <div class="card mb-3">
                        <div class="card-body">
                            <div class="d-flex flex-column align-items-center text-center">
                                <img src="{{$user->images()->where('path', 'LIKE', '/storage/images/profile/%')->value('path')}}" alt="Image" class="rounded-circle" width="150">
                                <div class="mt-3">
                                    <h4>{{$user->name}}</h4>
                                    <p class="text-secondary mb-1">{{$user->email}}</p>
                                    <p class="text-secondary mb-1">{{$user->role->type}}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-body">
                            <form action="{{route('update-agency-picture',$user)}}" method="POST" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <div class="mb-3">
                                    <label for="profile_picture" class="form-label">Change Profile Picture</label>
                                    <input type="file" class="form-control @error('image') is-invalid @enderror" id="profile_picture" name="image">
                                    @error('image')
                                    <div class="text-danger">{{$message}}</div>
                                    @enderror
                                </div>
                                <button type="submit" class="btn btn-primary">Upload</button>
                                <button class="btn btn-danger" type="submit" formaction="{{route('delete-agency-picture',$user)}}">Delete</button>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-md-8">
                    <div class="card mb-3">
                        <div class="card-header"><h4>Personal Information</h4></div>
                        <div class="card-body">
                            <form action="{{route('update-agency-information',$user)}}" method="POST">
                                @csrf
                                @method('PUT')
                                <div class="row mb-3">
                                    <div class="col-sm-3">
                                        <h6 class="mb-0">First Name</h6>
                                    </div>
                                    <div class="col-sm-9 text-secondary">
                                        <input type="text" class="form-control @error('first_name') is-invalid @enderror" name="first_name" value="{{$user->first_name}}">
                                        @error('first_name')
                                        <div class="text-danger">{{$message}}</div>
                                        @enderror
                                    </div>
                                </div>
                                <hr>
                                <div class="row mb-3">
                                    <div class="col-sm-3">
                                        <h6 class="mb-0">Last Name</h6>
                                    </div>
                                    <div class="col-sm-9 text-secondary">
                                        <input type="text" class="form-control @error('last_name') is-invalid @enderror" name="last_name" value="{{$user->last_name}}">
                                        @error('last_name')
                                        <div class="text-danger">{{$message}}</div>
                                        @enderror
                                    </div>
                                </div>
                                <hr>
                                <div class="row mb-3">
                                    <div class="col-sm-3">
                                        <h6 class="mb-0">Email</h6>
                                        @if($user->hasVerifiedEmail())
                                            <p class="text-success position-absolute">verified</p>
                                        @endif
                                    </div>
                                    <div class="col-sm-9 text-secondary">
                                        <input type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{$user->email}}">
                                        @error('email')
                                        <div class="text-danger">{{$message}}</div>
                                        @enderror
                                    </div>
                                </div>
                                <hr>
                                <div class="row mb-3">
                                    <div class="col-sm-3">
                                        <h6 class="mb-0">Gender</h6>
                                    </div>
                                    <div class="col-sm-9 text-secondary">
                                        <select class="form-control @error('gender') is-invalid @enderror" name="gender">
                                            @foreach($gender as $option)
                                                <option value="{{$option->name}}" {{$user->gender === $option->name ? 'selected' : ''}}>{{$option->name}}</option>
                                            @endforeach
                                        </select>
                                        @error('gender')
                                        <div class="text-danger">{{$message}}</div>
                                        @enderror
                                    </div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-sm-12">
                                        <button type="submit" class="btn btn-info">Save Changes</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row justify-content-end">
                <div class="col-md-8">
                    <div class="card mb-3">
                        <div class="card-header"><h4>Security</h4></div>
                        <div class="card-body">
                            <form action="{{route('update-agency-password',$user)}}" method="POST">
                                @csrf
                                @method('PUT')
                                <div class="row mb-3">
                                    <div class="col-sm-3">
                                        <h6 class="mb-0">Current Password</h6>
                                    </div>
                                    <div class="col-sm-9 text-secondary">
                                        <input type="password" class="form-control  @error('oldPass') is-invalid @enderror" name="oldPass" >
                                        @error('oldPass')
                                        <div class="text-danger">{{$message}}</div>
                                        @enderror
                                    </div>
                                </div>
                                <hr>
                                <div class="row mb-3">
                                    <div class="col-sm-3">
                                        <h6 class="mb-0">New Password</h6>
                                    </div>
                                    <div class="col-sm-9 text-secondary">
                                        <input type="password" class="form-control @error('password') is-invalid @enderror" name="password">
                                        @error('password')
                                        <div class="text-danger">{{$message}}</div>
                                        @enderror
                                    </div>
                                </div>
                                <hr>
                                <div class="row mb-3">
                                    <div class="col-sm-3">
                                        <h6 class="mb-0">Confirm New Password</h6>
                                    </div>
                                    <div class="col-sm-9 text-secondary">
                                        <input type="password" class="form-control @error('password_confirmation') is-invalid @enderror" name="password_confirmation" >
                                        @error('password_confirmation')
                                        <div class="text-danger">{{$message}}</div>
                                        @enderror
                                    </div>
                                </div>
                                <hr>

                                <div class="row">
                                    <div class="col-sm-12">
                                        <button type="submit" class="btn btn-info">Save New Password</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
