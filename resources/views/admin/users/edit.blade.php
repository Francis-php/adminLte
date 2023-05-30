@extends('adminlte::page')

@section('content')
    <div class="row justify-content-center">
        <div class="col-5">
            <br>
            <div class="card card-info">
                <div class="card-header "><h3 style="text-align: center">Edit User</h3></div>
                <form action="{{ route('users.update',$user->id) }}" method="POST" enctype="multipart/form-data">
                    <div class="card-body">
                        @csrf
                        @method('PUT')

                        <div class="form-group">
                            <label>Profile Image:</label><br>
                            <img src="{{asset('images/'.$user->image)}}" alt="Profile Image" width="100">
                            <input type="file" name="image" class="form-control-file  @error('image') is-invalid @enderror">
                            @error('image')
                            <div class="alert text-danger">{{$message}}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="name">Name:</label>
                            <input type="text" name="name" value="{{ $user->name }}" id="name" class="form-control @error('name') is-invalid @enderror" placeholder="Name">
                            @error('name')
                            <br>
                            <div class="alert text-danger">{{$message}}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="email">Email:</label>
                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" value="{{ $user->email }}" name="email" placeholder="Email">
                            @error('email')
                            <br>
                            <div class="alert text-danger">{{$message}}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="role">Role:</label>
                            <select name="type" id="role" class="form-control @error('type') is-invalid @enderror">
                                <option value="2">Admin</option>
                                <option value="1">User</option>
                            </select>
                            @error('type')
                            <br>
                            <div class="alert text-danger">{{$message}}</div>
                            @enderror
                        </div><br>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-info" >Submit</button>
                        <a class="btn btn-default float-right" href="{{ route('users.index') }}"> Back</a>
                    </div>
                </form>
            </div>
        </div>
    </div>




@endsection
