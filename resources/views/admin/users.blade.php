@extends('adminlte::page')
@section('usermenu_body')
    <a class="btn btn-default btn-flat float-right  btn-block "
       href="{{route('profile')}}" >
        <i class="fas fa-fw fa-user"></i>
        Profile
    </a>
@endsection
@section('title', 'Dashboard')
@section('plugins.Datatables', true)
@section('content')
    <div class="container-fluid ">
        <div class="row justify-content-center">
            <div class="col-11">
                <div class="card">
                    <div class="card-header text-center"><h3>Users</h3></div>
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
                            <table id="myTable" class="table table-striped " style="width: 100%">
                                <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Gender</th>
                                    <th>Type</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                            </table>
                        </div>
                    </div>

                </div>
            </div>
        </div>
        @push('css')
            <link rel="stylesheet" href="{{asset('css/cust-style.css')}}">
        @endpush
        @push('js')
            <script src="https://cdn.datatables.net/buttons/2.0.1/js/dataTables.buttons.min.js"></script>
            <script src="{{asset('js/datatable.js')}}"></script>
        @endpush
@endsection
