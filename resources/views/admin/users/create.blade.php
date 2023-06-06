@extends('adminlte::page')

@section('content')
    <div class="row justify-content-center">
        <div class="col-5">
            <br>
            <div class="card card-primary">
                <div class="card-header "><h3 style="text-align: center">Create</h3></div>
                <form action="{{ route('users.store') }}" method="POST">
                    <div class="card-body">
                        @csrf
                        @csrf
                        <div class="form-group row">
                            <label for="first_name">First Name:</label>
                            <input id="first_name" type="text" name="first_name"
                                   class="form-control @error('first_name') is-invalid @enderror" placeholder="First Name"
                                   value="{{old('first_name')}}">
                            @error('first_name')
                            <br>
                            <div class="alert text-danger">{{$message}}</div>
                            @enderror
                        </div>
                        <div class="form-group row">
                            <label for="last_name">Last Name:</label>
                            <input id="last_name" type="text" name="last_name"
                                   class="form-control @error('last_name') is-invalid @enderror" placeholder="Last Name"
                                   value="{{old('last_name')}}">
                            @error('last_name')
                            <br>
                            <div class="alert text-danger">{{$message}}</div>
                            @enderror
                        </div>
                        <div class="form-group row">
                            <label for="gender">Gender:</label>
                            <select id="gender" name="gender" class="form-control @error('gender') is-invalid @enderror">
                                <option value="male">Male</option>
                                <option value="female">Female</option>
                                <option value="other">Other</option>
                            </select>
                        </div>
                        <div class="form-group row">
                            <label for="email">Email:</label>
                            <input id="email" type="email" name="email"
                                   class="form-control @error('email') is-invalid @enderror" placeholder="Email"
                                   value="{{old('email')}}">
                            @error('email')
                            <br>
                            <div class="alert text-danger">{{$message}}</div>
                            @enderror
                        </div>
                        <div class="form-group row">
                            <label for="password">Password:</label>
                            <input type="password" id="password" name="password"
                                   class="form-control @error('password') is-invalid @enderror" placeholder="Password"
                                   value="{{old('password')}}">
                            @error('password')
                            <br>
                            <div class="alert text-danger">{{$message}}</div>
                            @enderror
                        </div>
                        <div class="form-group row">
                            <label for="role">Role:</label>
                            <select id="role" name="type" class="form-control @error('type') is-invalid @enderror">
                                <option value="2">Admin</option>
                                <option value="1">User</option>
                            </select>
                            @error('type')
                            <br>
                            <div class="alert text-danger">{{$message}}</div>
                            @enderror
                        </div>
                        <br>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">Submit</button>
                        <a class="btn btn-default float-right" href="{{ route('users.index') }}"> Back</a>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection
