/**
 | ----------------------------------------------------------------
 |  List of companies
 | ----------------------------------------------------------------
 |
 | Initialize datatable and fetch companies data
 | with server side rendering using ajax
 |
 */
var compantTable = $('#init-company-datatable').DataTable({
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
                compantTable.ajax.reload();
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
                        compantTable.ajax.reload();
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

/**
 | ----------------------------------------------------------------
 |  List of employees
 | ----------------------------------------------------------------
 |
 | Initialize datatable and fetch employees data
 | with server side rendering using ajax
 |
 */
var employeeTable = $('#init-employee-datatable').DataTable({
    processing: true,
    serverSide: true,
    ajax: {
        type: "GET",
        url: $('#init-employee-datatable').attr('url'),
    },
    columns: [
        { data: 'fullname', name: 'fullname' },
        { data: 'email', name: 'email' },
        { data: 'phone', name: 'phone' },
        { data: 'company.name', name: 'company.name' },
        { data: 'action', name: 'action', orderable: false, searchable: false },
    ]
});

/**
 | ----------------------------------------------------------------
 |  Create employee
 | ----------------------------------------------------------------
 |
 | Send ajax request to store employee
 |
 */
$('#create-employee-form').submit(function (e) {
    e.preventDefault();
    let form = $('#create-employee-form');

    $.ajaxSetup({
        headers: {
            'Accepts': 'application/json',
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
        }
    });

    $.ajax({
        type: 'POST',
        url: form.attr('action'),
        data: form.serialize(),
        success: function (response) {
            if (response.success === true) {
                $('.field-first-name').val(null);
                $('.field-last-name').val(null);
                $('.field-phone').val(null);
                $('.field-email').val(null);
                $('.field-company').val(null);
                $('#create-employee-modal').modal('hide');
                employeeTable.ajax.reload();
            } else {
                if (response) {
                    $('.error-first-name').html(response.errors.first_name ?? '');
                    $('.error-last-name').html(response.errors.last_name ?? '');
                    $('.error-phone').html(response.errors.phone ?? '');
                    $('.error-email').html(response.errors.email ?? '');
                    $('.error-company').html(response.errors.company_id ?? '');
                }
            }
        },
        error: function (error) {
            console.log(error);
        }
    });
});

/**
 | ----------------------------------------------------------------
 |  Cancel employee form
 | ----------------------------------------------------------------
 |
 | Remove errors, labels and empty the fields
 |
 */
$('.cancel-employee-form').click(function () {
    $('.field-first-name').val(null);
    $('.field-last-name').val(null);
    $('.field-phone').val(null);
    $('.field-email').val(null);
    $('.field-company').val(null);

    $('.error-first-name').html(null);
    $('.error-last-name').html(null);
    $('.error-phone').html(null);
    $('.error-email').html(null);
    $('.error-company').html(null);
});

/**
 | ----------------------------------------------------------------
 |  Update employee
 | ----------------------------------------------------------------
 |
 | Send ajax request to store employee
 |
 */
// $('#init-employee-datatable').on('click', '.edit-btn', function () {
//     var id = $(this).attr('data-id');

//     ('#' + id).submit(function (e) {
//         e.preventDefault();
//         console.log($('.field-first-name').val());
//     });
    // var formId = 'edit-employee-form' + id;
    // alert(formId);
    // e.preventDefault();
    // var id = $('.edit-employee').attr('data-id');
    // console.log(id);
// });

// var formId = 'edit-employee-form-' + id;
// $('.close').click(function () {
//     console.log(formId);
// });


// const updateEmplyee = (e) => {
//     e.preventDefault();
//     console.log(e);
    // e.preventDefault();
    // let form = $('#edit-employee-form');

    // $.ajaxSetup({
    //     headers: {
    //         'Accepts': 'application/json',
    //         'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
    //     }
    // });

    // $.ajax({
    //     type: 'POST',
    //     url: form.attr('action'),
    //     data: form.serialize(),
    //     success: function (response) {
    //         if (response.success === true) {
    //             $('.field-first-name').val(null);
    //             $('.field-last-name').val(null);
    //             $('.field-phone').val(null);
    //             $('.field-email').val(null);
    //             $('.field-company').val(null);
    //             $('#create-employee-modal').modal('hide');
    //             employeeTable.ajax.reload();
    //         } else {
    //             if (response) {
    //                 $('.error-first-name').html(response.errors.first_name ?? '');
    //                 $('.error-last-name').html(response.errors.last_name ?? '');
    //                 $('.error-phone').html(response.errors.phone ?? '');
    //                 $('.error-email').html(response.errors.email ?? '');
    //                 $('.error-company').html(response.errors.company_id ?? '');
    //             }
    //         }
    //     },
    //     error: function (error) {
    //         console.log(error);
    //     }
    // });
// }

/**
 | ----------------------------------------------------------------
 |  Delete employee
 | ----------------------------------------------------------------
 |
 | Send ajax request to delete employee and refresh the datatable
 |
 */
$('#init-employee-datatable').on('click', '.delete-button', function () {
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
                url: $(this).attr('data-url'),
                success: function (response) {
                    if (response.success == true) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Deleted!',
                            text: response.message
                        })
                        employeeTable.ajax.reload();
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
});
