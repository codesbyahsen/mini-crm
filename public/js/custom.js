// const fetchCompanies = () => {
//     $.ajaxSetup({
//         headers: {
//             'Accepts': 'application/json',
//             'X-CSRF-TOKEN': $('meta[name="X-CSRF-TOKEN"]').attr('content')
//         }
//     });

//     $.ajax({
//         type: 'GET',
//         url: 'companies',
//         success: function (response) {
//             if (response.success == true) {
//                 var html = '';
//                 if (response.data.length > 0) {
//                     response.data.forEach(function(item, index) {
//                         html += '';
//                     });
//                 }
//             }
//         },
//         error: function (error) {
//             console.log(error.status);
//         }
//     });
// }

// $(document).ready(function() {
//     var table = $('.datatable-init').DataTable();
//     table.destroy();

//     $('.datatable-init').DataTable({
//         // DataTable initialization options
//     });
// });

$(function () {

    var table = $('#datatable-init').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            type: "GET",
            url: "companies",
        },
        columns: [
            {data: 'logo', name: 'logo'},
            {data: 'name', name: 'name'},
            {data: 'email', name: 'email'},
            {data: 'website', name: 'website'},
            {data: 'action', name: 'action', orderable: false, searchable: false},
        ]
    });

  });

$('#add-company-form').submit(function (e) {
    e.preventDefault();
    let url = $('#add-company-form').attr('action');
    let formData = new FormData(this);

    $.ajaxSetup({
        headers: {
            'Accepts': 'application/json',
            'X-CSRF-TOKEN': $('meta[name="X-CSRF-TOKEN"]').attr('content')
        }
    });

    $.ajax({
        type: 'POST',
        url: url,
        data: formData,
        contentType: false,
        processData: false,
        success: function (response) {
            if (response.success === true) {
                $('.field-logo').val('');
                $('.field-name').val('');
                $('.field-email').val('');
                $('.field-website').val('');
            } else {
                alert(response);
            }
        },
        error: function (error) {
            console.log(error);
        }
    });

    $('#add-company').modal('hide');
});

$('#edit-company-form').submit(function (e) {
    e.preventDefault();
    let url = $('#edit-company-form').attr('action');
    let formData = new FormData(this);

    $.ajaxSetup({
        headers: {
            'Accepts': 'application/json',
            'X-CSRF-TOKEN': $('meta[name="X-CSRF-TOKEN"]').attr('content')
        }
    });

    $.ajax({
        type: 'PUT',
        url: url,
        data: formData,
        contentType: false,
        processData: false,
        success: function (response) {
            if (response.success === true) {
                $('.field-logo').val('');
                $('.field-name').val('');
                $('.field-email').val('');
                $('.field-website').val('');
            } else {
                alert(response);
            }
        },
        error: function (error) {
            console.log(error);
        }
    });

    $('#add-company').modal('hide');
});

