@extends('adminlte::page')

@section('title', 'Dashboard')
@section('plugins.Datatables', true)
@section('content')
    <div class="container-fluid ">
        <br>
        <div class="row justify-content-center">
            <div class="col-11">
                <div class="card">
                    <div class="card-header text-center"><h3 >Users</h3></div>
                    <div class="card-body">
                        @if(session('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                        @endif
                        <div class="table-responsive" >
                            <table id="myTable" class="table table-striped " style="width: 100%">
                                <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Email</th>
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
        <br>
        <style>
            #myTable_wrapper .dt-buttons,
            #myTable_wrapper .dataTables_length
            {
                display: inline-flex;
                align-items: center;

            }
            #myTable_wrapper .dataTables_length{
                padding-right: 1%;
            }
        </style>

        @endsection

        @push('js')
            <script src="https://cdn.datatables.net/buttons/2.0.1/js/dataTables.buttons.min.js"></script>

            <script>
                $(document).ready(function () {
                    $('#myTable').DataTable({
                        dom: 'lBfrtip',
                        buttons: [
                            {
                                text: 'Create New User',
                                action: function (){
                                    window.location.href = "{{ route('users.create') }}";
                                },
                                className: 'btn btn-success '
                            }
                        ],
                        serverSide: true,
                        processing: true,

                        ajax: '{!! route('get-users') !!}',
                        columns: [
                            {data: 'name', name: 'name'},
                            {data: 'email', name: 'email'},
                            {data: 'type', name: 'type'},
                            {data:'action', name: 'action', orderable:false,searchable:false},
                        ]
                    });
                });
            </script>
    @endpush



