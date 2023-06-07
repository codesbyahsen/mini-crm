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


// $(function () {

//     var table = $('.data-table').DataTable({
//         processing: true,
//         serverSide: true,
//         ajax: "{{ route('users.index') }}",
//         columns: [
//             { data: 'id', name: 'id' },
//             { data: 'name', name: 'name' },
//             { data: 'email', name: 'email' },
//             { data: 'action', name: 'action', orderable: false, searchable: false },
//         ]
//     });

// });

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

