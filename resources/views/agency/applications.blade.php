@extends('layouts.agency')
@push('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css">

@endpush
@section('content')
    <div class="container-fluid ">
        <div class="row justify-content-center">
            <div class="col-11">
                <div class="card">
                    <div class="card-header text-center"><h3>Applications</h3></div>
                    <div class="card-body">
                        @if(session('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                        @endif
                        @if(session('error'))
                            <div class="alert alert-danger">
                                {{session('error')}}
                            </div>
                        @endif
                        <div class="table-responsive">
                            <table id="ApplicationTable" class="table table-striped " style="width: 100%">
                                <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Tickets</th>
                                    <th>Total Cost</th>
                                    <th>Ticket Price</th>
                                    <th>Post title</th>
                                    <th>Start Date</th>
                                    <th>End Date</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($users as $user)

                                        <tr>
                                            <td>{{ $user->name }}</td>
                                            <td>{{ $user->pivot->tickets }}</td>
                                            <td>{{ $user->pivot->cost }}</td>
                                            <td>{{$post->price}}</td>
                                            <td>{{ $post->title }}</td>
                                            <td>{{ $post->start_date }}</td>
                                            <td>{{ $post->end_date }}</td>
                                            <td><a class="btn btn-danger" href="#" onclick="document.getElementById().submit();">Cancel</a>
                                                <form id="cancel-form-{{$user->id}}" action="{{route('delete-application',$user->id)}} " method="POST" style="display: none;">
                                                    @csrf
                                                    @method('DELETE')
                                                </form>
                                            </td>
                                        </tr>

                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
@endsection

