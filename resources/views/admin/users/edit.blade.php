@extends('adminlte::page')

@section('content')
    <div class="row justify-content-center">
        <div class="col-5">
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
            <br>
            <div class="card card-info">
                <div class="card-header "><h3 style="text-align: center">Edit User</h3></div>
                <div class="card-body">
                    <form action="{{route('updatePicUser',$user->id)}}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="text-center">
                            @if($user->images()->where('path', 'LIKE', '/storage/images/profile/%'))
                                <div>
                                    <img class="rounded-circle mr-3" alt="" width="100px"
                                         src="{{$user->images()->where('path', 'LIKE', '/storage/images/profile/%')->value('path')}}">
                                </div>
                            @endif
                        </div>
                        <div class="form-group">
                            <div class="col">
                                <label for="formFile" class="form-label">Profile Image:</label>
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
                                </div>
                                @error('image')
                                <div class="text-danger">{{$message}}</div>
                                @enderror
                            </div>
                        </div>
                    </form>
                    <form id="info" action="{{ route('users.update',$user->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <label for="first_name">First Name:</label>
                            <input type="text" name="first_name" value="{{ $user->first_name}}" id="first_name"
                                   class="form-control @error('first_name') is-invalid @enderror" placeholder="First Name">
                            @error('first_name')
                            <br>
                            <div class="alert text-danger">{{$message}}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="last_name">Last Name:</label>
                            <input type="text" name="last_name" value="{{ $user->last_name}}" id="last_name"
                                   class="form-control @error('last_name') is-invalid @enderror" placeholder="Last Name">
                            @error('last_name')
                            <br>
                            <div class="alert text-danger">{{$message}}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="email">Email:</label>
                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror"
                                   value="{{ $user->email }}" name="email" placeholder="Email">
                            @error('email')
                            <br>
                            <div class="alert text-danger">{{$message}}</div>
                            @enderror
                        </div>


                        <div class="form-group">
                            <label for="gender">Gender:</label>
                            <select id="gender" name="gender" class="form-control @error('gender') is-invalid @enderror">
                                <option value="male" {{ $user->gender === 'male' ? 'selected' : '' }}>Male</option>
                                <option value="female" {{ $user->gender === 'female' ? 'selected' : '' }}>Female</option>
                                <option value="other" {{ $user->gender ==='other' ? 'selected' : '' }}>Other</option>
                            </select>
                            @error('gender')
                            <div class="text-danger">{{$message}}</div>
                            @enderror
                        </div>


                        <br>
                    </form>
                </div>
                <div class="card-footer">
                    <button form="info" type="submit" class="btn btn-info">Submit</button>
                    <a class="btn btn-default float-right" href="{{ route('users.index') }}"> Back</a>
                </div>

            </div>
        </div>
    </div>
    @push('js')
        <script src="{{ asset('js/image-upload.js') }}"></script>
    @endpush

@endsection
