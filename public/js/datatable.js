$(document).ready(function () {
    $('#myTable').DataTable({
        dom: 'lBfrtip',
        buttons: [
            {
                text: 'Create New User',
                action: function () {
                    window.location.href = "/users/create";
                },
                className: 'btn btn-success '
            }
        ],
        serverSide: true,
        processing: true,

        ajax: '/get-users',
        columns: [
            {
                data: null,
                render: function (data){
                    return data.first_name + ' ' + data.last_name;
                },
                name: 'name'
            },
            {data: 'email', name: 'email'},
            {data:'gender', name: 'gender'},
            {data: 'type', name: 'type'},
            {data: 'action', name: 'action', orderable: false, searchable: false},
        ]
    });
});
