@extends('adminlte::page')

@section('usermenu_body')
    <a class="btn btn-default btn-flat float-right  btn-block "
       href="{{route('profile')}}" >
        <i class="fas fa-fw fa-user"></i>
        Profile
    </a>
@endsection

@section('content')
    <div class="container-fluid ">
        <div class="row justify-content-center">
            <div class="col-11">
                <div class="card">
                    <div class="card-header text-center"><h3>Agencies</h3></div>
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
                            <table  class="table table-striped " style="width: 100%">
                                <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Total Posts</th>
                                    <th>Total Earnings</th>
                                    <th>Avg(Earning/Post)</th>
                                    <th>Avg(Pricing/Post)</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($agencies as $agency)
                                    <tr>
                                        <td><a href="{{route('show-agency',$agency->id)}}">{{$agency->name}}</a></td>
                                        <td>{{$agency->posts_count}}</td>
                                        <td>
                                            {{$agency->totalEarnings}} $
                                        </td>
                                        <td>{{$agency->totalEarnings/$agency->posts_count}} $</td>
                                        <td>{{$agency->posts_sum_price/$agency->posts_count}} $</td>
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
