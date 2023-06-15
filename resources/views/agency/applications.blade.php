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
                                    <th>User</th>
                                    <th>Tickets</th>
                                    <th>Cost</th>
                                    <th>Post title</th>
                                    <th>Start Date</th>
                                    <th>End Date</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                            </table>
                        </div>
                    </div>

                </div>
            </div>
        </div>


    @push('js')
            <script src="https://cdn.datatables.net/buttons/2.0.1/js/dataTables.buttons.min.js"></script>
            <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
            <script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"></script>
            <script src="https://cdn.datatables.net/v/bs5/jq-3.6.0/dt-1.13.4/datatables.min.js"></script>
            <script>
                $(document).ready(function () {
                    $('#ApplicationTable').DataTable({
                        processing: true,
                        serverSide: true,
                        ajax: "{{ route('your-data-route') }}",
                        columns: [
                            {data: 'user', name: 'user'},
                            {data: 'tickets', name: 'tickets'},
                            {data: 'cost', name: 'cost'},
                            {data: 'post_title', name: 'post.title'},
                            {data: 'start_date', name: 'start_date'},
                            {data: 'end_date', name: 'end_date'},
                            {data: 'action', name: 'action', orderable: false, searchable: false},
                        ]
                    });
                });
            </script>

    @endpush

@endsection

