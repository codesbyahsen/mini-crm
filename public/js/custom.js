/**
 | ----------------------------------------------------------------
 |  List of companies
 | ----------------------------------------------------------------
 |
 | Initialize datatable and fetch companies data
 | with server side rendering using ajax
 |
 */
var table = $('#init-company-datatable').DataTable({
    processing: true,
    serverSide: true,
    ajax: {
        type: "GET",
        url: "companies",
    },
    columns: [
        { data: 'logo', name: 'logo' },
        { data: 'name', name: 'name' },
        { data: 'email', name: 'email' },
        { data: 'website', name: 'website' },
        { data: 'action', name: 'action', orderable: false, searchable: false },
    ]
});

/**
 | ----------------------------------------------------------------
 |  Create company
 | ----------------------------------------------------------------
 |
 | Send ajax request to store company
 |
 */
$('#create-company-form').submit(function (e) {
    e.preventDefault();
    let formData = new FormData(this);

    $.ajaxSetup({
        headers: {
            'Accepts': 'application/json',
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $.ajax({
        type: 'POST',
        url: 'companies',
        data: formData,
        contentType: false,
        processData: false,
        success: function (response) {
            if (response.success === true) {
                $('.custom-file-label').html(null);
                $('.field-logo').val(null);
                $('.field-name').val(null);
                $('.field-email').val(null);
                $('.field-website').val(null);
                table.ajax.reload();
            } else {
                if (response.errors) {
                    $('#create-company-modal').modal('show');
                    $('.error-logo').html(response.errors.logo);
                    $('.error-name').html(response.errors.name);
                    $('.error-email').html(response.errors.email);
                    $('.error-website').html(response.errors.website);
                }
            }
        },
        error: function (error) {
            console.log(error);
        }
    });

    $('#create-company-modal').modal('hide');
});

/**
 | ----------------------------------------------------------------
 |  Update company
 | ----------------------------------------------------------------
 |
 | Send ajax request to update company
 |
 */
$('#edit-company-form').submit(function (e) {
    e.preventDefault();
    let url = $('#edit-company-form').attr('action');
    let formData = new FormData(this);

    $.ajaxSetup({
        headers: {
            'Accepts': 'application/json',
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
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

/**
 | ----------------------------------------------------------------
 |  Cancel the forms
 | ----------------------------------------------------------------
 |
 | Remove errors, labels and empty the fields
 |
 */
$('.cancel').click(function () {
    $('.field-logo').val(null);
    $('.field-name').val(null);
    $('.field-email').val(null);
    $('.field-website').val(null);

    $('.error-logo').html(null);
    $('.error-name').html(null);
    $('.error-email').html(null);
    $('.error-website').html(null);
    $('#create-company-form').validate().resetForm();
    $('.custom-file-label').html(null);
});

/**
 | ----------------------------------------------------------------
 |  Delete company
 | ----------------------------------------------------------------
 |
 | Send ajax request to delete company and refresh the datatable
 |
 */
const deleteCompany = (url) => {
    Swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
        if (result.isConfirmed) {

            $.ajaxSetup({
                headers: {
                    'Accepts': 'application/json',
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                type: 'DELETE',
                url: url,
                success: function (response) {
                    if (response.success == true) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Deleted!',
                            text: response.message
                        })
                        table.ajax.reload();
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...!',
                            text: response.message,
                        })
                    }
                }
            });
        }
    })
};
