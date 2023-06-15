@extends('adminlte::page')
@section('usermenu_body')
    <a class="btn btn-default btn-flat float-right  btn-block "
       href="{{route('profile')}}" >
        <i class="fas fa-fw fa-user"></i>
        Profile
    </a>
@endsection
@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Profile</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">
                            <a href="{{route('home')}}">Home</a>
                        </li>
                        <li class="breadcrumb-item active">
                            Admin Profile
                        </li>
                    </ol>
                </div>
            </div>

            <div class="row justify-content-center">
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
            </div>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-3 ">
                    <div class="card card-primary card-outline">
                        <div class="card-body box-profile">
                            <div class="text-center">
                                <img class="profile-user-img img-fluid img-circle" alt="Profile Image"
                                     src="{{$user->images()->where('path', 'LIKE', '/storage/images/profile/%')->value('path')}}">
                            </div>
                        </div>
                        <h3 class="profile-username text-center">{{$user->first_name.' '.$user->last_name}}</h3>
                        <p class="text-muted text-center">{{$user->email}}</p>
                        <p class="text-muted text-center">{{$user->role->type}}</p>
                    </div>
                </div>

                <div class="col-md-9">
                    <div class="card">
                        <div class="card-header p-2">
                            <ul class="nav nav-pills">
                                <li class="nav-item">
                                    <a id="information-tab"
                                       class="nav-link @if($errors->has('password') || $errors->has('password_confirmation'))
                                    @else active @endif" href="#information" data-toggle="tab">
                                        Personal Information
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a id="password-tab"
                                       class="nav-link @error('password') active @enderror" href="#password"
                                       data-toggle="tab">
                                        Password
                                    </a>
                                </li>
                            </ul>
                        </div>
                        <div class="card-body ">
                            <div class="tab-content">
                                <div id="information" class="tab-pane @if($errors->has('password') || $errors->has('password_confirmation'))
                                    @else active @endif">
                                    <form id="informationChange" action="{{route('updateInfo',$user->id)}}"
                                          class="form-horizontal"
                                          method="POST">
                                        @csrf
                                        @method('PUT')
                                        <div class="form-group row">
                                            <label for="first_name">First Name:</label>
                                            <input id="first_name" type="text" name="first_name" value="{{$user->first_name}}"
                                                   class="form-control @error('first_name') is-invalid @enderror"
                                                   placeholder="First Name">
                                            @error('first_name')
                                            <div class="text-danger">{{$message}}</div>
                                            @enderror
                                        </div>
                                        <div class="form-group row">
                                            <label for="last_name">Last Name:</label>
                                            <input id="last_name" type="text" name="last_name" value="{{$user->last_name}}"
                                                   class="form-control @error('last_name') is-invalid @enderror"
                                                   placeholder="Last Name">
                                            @error('last_name')
                                            <div class="text-danger">{{$message}}</div>
                                            @enderror
                                        </div>

                                        <div class="form-group row">
                                            <label for="email">Email:</label>
                                            <input id="email" type="email"
                                                   class="form-control @error('email') is-invalid @enderror"
                                                   value="{{$user->email}}" name="email" placeholder="Email">
                                            @error('email')
                                            <div class="text-danger">{{$message}}</div>
                                            @enderror
                                        </div>
                                        <div class="form-group row">
                                            <label for="gender">Gender:</label>
                                            <select id="gender" name="gender" class="form-control @error('type') is-invalid @enderror">
                                                @foreach($gender as $option)
                                                    <option value="{{$option->name}}" {{$user->gender === $option->name ? 'selected' : ''}}>{{$option->name}}</option>
                                                @endforeach
                                            </select>
                                            @error('gender')
                                            <div class="text-danger">{{$message}}</div>
                                            @enderror
                                        </div>
                                    </form>
                                    <form action="{{route('updatePic',$user->id)}}" method="POST"
                                          enctype="multipart/form-data">
                                        @csrf
                                        @method('PUT')
                                        <div class="form-group">
                                            <label for="formFile" class="form-label">Profile Image:</label><br>
                                            <div class="input-group">
                                                <div class="custom-file">
                                                    <input type="file" name="image" id="formFile"
                                                           class="custom-file-input @error('image') is-invalid @enderror"
                                                           onchange="updateFileName(this)">
                                                    <label class="custom-file-label" for="formFile">Choose file</label>
                                                </div>
                                                <div class="input-group-append">
                                                    <button class="btn btn-info" type="submit">Upload</button>
                                                </div>
                                                <div class="input-group-append">
                                                    <button class="btn btn-danger" type="submit" formaction="{{route('deletePic',$user->id)}}">Delete</button>
                                                </div>
                                            </div>
                                            @error('image')
                                            <div class="text-danger">{{$message}}</div>
                                            @enderror
                                        </div>
                                    </form>
                                    <div class="text-center mt-5">
                                        <button type="submit" form="informationChange" class="btn btn-info">Save Profile
                                        </button>
                                    </div>
                                </div>
                                <div id="password" class="tab-pane @error('password') active @enderror">
                                    <form action="{{route('updatePass',$user->id)}}" class="form-horizontal" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <input type="hidden" name="first_name" value="{{$user->first_name}}">
                                        <input type="hidden" name="last_name" value="{{$user->last_name}}">
                                        <input type="hidden" name="email" value="{{$user->email}}">
                                        <div class="form-group row">
                                            <label for="oldPass">Old Password:</label>
                                            <input id="oldPass" type="password" name="oldPass"
                                                   class="form-control @error('oldPass') is-invalid @enderror">
                                            @error('oldPass')
                                            <div class="text-danger">{{$message}}</div>
                                            @enderror
                                        </div>
                                        <div class="form-group row">
                                            <label for="password">New Password:</label>
                                            <input id="password" type="password" name="password"
                                                   class="form-control @error('password') is-invalid @enderror">
                                            @error('password')
                                            <div class="text-danger">{{$message}}</div>
                                            @enderror
                                        </div>
                                        <div class="form-group row">
                                            <label for="password_confirmation">Repeat Password:</label>
                                            <input id="password_confirmation" type="password"
                                                   name="password_confirmation"
                                                   class="form-control @error('password_confirmation') is-invalid @enderror">
                                            @error('password_confirmation')
                                            <div class="text-danger">{{$message}}</div>
                                            @enderror
                                        </div>

                                        <div class="text-center mt-5">
                                            <button type="submit" class="btn btn-danger">Change Password</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection

@push('js')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="{{ asset('js/image-upload.js') }}"></script>
@endpush
