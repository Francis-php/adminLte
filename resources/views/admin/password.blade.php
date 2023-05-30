@extends('adminlte::page')

@section('content')
    <div class="row justify-content-center">
        <div class="col-5">
            <br>
            <div class="card card-red">
                <div class="card-header text-center"><h3>Edit Password</h3></div>
                @if(session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif
                <form action="{{route('updatePass')}}" class="form-horizontal" method="POST">
                    <div class="card-body">
                        @csrf
                        @method('PUT')
                        <div class="form-group row">
                            <label for="oldPass">Old Password:</label>
                            <input id="oldPass" type="password" name="oldPass"
                                   class="form-control @error('oldPass') is-invalid @enderror">
                            @error('oldPass')

                            <div class="alert text-danger">{{$message}}</div>
                            @enderror
                        </div>
                        <div class="form-group row">
                            <label for="password">New Password:</label>
                            <input id="password" type="password" name="password"
                                   class="form-control @error('password') is-invalid @enderror">
                            @error('password')

                            <div class="alert text-danger">{{$message}}</div>
                            @enderror
                        </div>
                        <div class="form-group row">
                            <label for="password_confirmation">Repeat Password:</label>
                            <input id="password_confirmation" type="password" name="password_confirmation"
                                   class="form-control @error('password_confirmation') is-invalid @enderror">
                            @error('password_confirmation')

                            <div class="alert text-danger">{{$message}}</div>
                            @enderror

                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-danger">Submit</button>
                        <a class="btn btn-default float-right" href="{{route('home')}}"> Back</a>
                    </div>
                </form>

            </div>
        </div>
    </div>


@endsection
