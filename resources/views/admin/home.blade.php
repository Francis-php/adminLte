@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>Dashboard</h1>
@stop
@section('preloader.enabled', true)
@section('content')
    <div class="row">
        <div class="col-lg-3 col-6">
            <div class="small-box bg-info">
                <div class="inner">
                    <h3>{{$users}}</h3>
                    <p>Total Users</p>
                </div>
                <a class="small-box-footer" href="{{ route('users.index') }}">More info</a>
            </div>
        </div>
        <div class="col-lg-3 col-6">
            <div class="small-box bg-success">
                <div class="inner">
                    <h3>{{$newUsers}}</h3>
                    <p>New Users</p>
                </div>
                <a class="small-box-footer" href="{{ route('users.index') }}">More info</a>
            </div>
        </div>
        <div class="col-lg-3 col-6">
            <div class="small-box bg-warning">
                <div class="inner">
                    <h3>{{$admins}}</h3>
                    <p>Total Admins</p>
                </div>
                <a class="small-box-footer" href="{{ route('users.index') }}">More info</a>
            </div>
        </div>
        <div class="col-lg-3 col-6">
            <div class="small-box bg-danger">
                <div class="inner">
{{--                    <h3>{{sprintf('%2d Hours %2dM %02dS', $hours, $minutes,$seconds)}}</h3>--}}
                    <p>Time logged in</p>
                </div>
                <a class="small-box-footer" href="#" onclick="document.getElementById('logout-form').submit();">Log Out</a>
            </div>
        </div>
    </div>
{{--    <div class="row">--}}
{{--        <div class="col">--}}
{{--            <div class="card bg-gradient-success">--}}
{{--                <div class="card-header border-0">--}}
{{--                    <h3 class="card-title">--}}
{{--                        <i class="far fa-calendar-alt"></i>--}}
{{--                        Calendar--}}
{{--                    </h3>--}}
{{--                </div>--}}
{{--                <div class="card-body pt-0">--}}
{{--                    <div id="calendar" style="width: 100%">--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </div>--}}

{{--    @push('css')--}}
{{--        <style>--}}
{{--            #calendar thead th {--}}
{{--                background-color: green;--}}
{{--                padding: 8px;--}}
{{--                border: none;--}}
{{--            }--}}
{{--            #calendar tbody td {--}}
{{--            padding-top: 17px;--}}
{{--                border: none;--}}
{{--            }--}}
{{--            #calendar .fc-day-number{--}}
{{--                margin-right: 40%;--}}
{{--            }--}}

{{--            #calendar .fc-today {--}}
{{--                background-color: #20ae20;--}}
{{--            }--}}
{{--        </style>--}}
{{--    @endpush--}}


{{--    @push('js')--}}
{{--        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>--}}
{{--        <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>--}}
{{--        <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.10.2/fullcalendar.min.js"></script>--}}
{{--        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.10.2/fullcalendar.min.css" />--}}
{{--        <script>--}}
{{--            $(document).ready(function() {--}}
{{--                $('#calendar').fullCalendar({--}}
{{--                    height: 600,--}}
{{--                });--}}
{{--            });--}}
{{--        </script>--}}
{{--    @endpush--}}
@endsection

