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
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($users as $user)

                                        <tr>
                                            <td>{{ $user->name }}</td>
                                            <td>{{ $user->pivot->tickets}}</td>
                                            <td>{{ $user->pivot->cost}} $</td>
                                            <td><a class="btn btn-danger" href="#" onclick="document.getElementById('cancel-form-{{$user->id}}').submit();">Cancel</a>
                                                <form id="cancel-form-{{$user->id}}" action="{{route('delete-application',[$user->id, $post->id])}} " method="POST" style="display: none;">
                                                    @csrf
                                                    @method('DELETE')
                                                </form>
                                            </td>
                                        </tr>
                                @endforeach
                                </tbody>
                                <tfoot>
                                <tr>
                                    <td><h5>Title</h5> <p>{{$post->title}}</p></td>
                                    <td><h5>Tickets Sold</h5><p>{{$post->users()->sum('tickets')}}</p></td>
                                    <td><h5>Total earnings </h5><p>{{$post->users()->sum('tickets') * $post->price}} $</p></td>
                                    <td><h5>Ticket Cost</h5><p>{{$post->price}} $</p></td>
                                </tr>
                                </tfoot>
                            </table>




                        </div>
                    </div>
                </div>
            </div>
        </div>
@endsection

