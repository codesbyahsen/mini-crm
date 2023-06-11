// ============================== |> Module One <| ============================== //

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
        url: $(this).attr('url'),
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

    $.ajaxSetup({
        headers: {
            'Accepts': 'application/json',
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $.ajax({
        type: 'POST',
        url: $(this).attr('action'),
        data: new FormData(this),
        contentType: false,
        processData: false,
        success: function (response) {
            if (response.success === true) {
                $('.custom-file-label').html(null);
                $('.field-logo').val(null);
                $('.field-name').val(null);
                $('.field-email').val(null);
                $('.field-website').val(null);
                $('#create-company-modal').modal('hide');
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
$('#init-company-datatable').on('click', '.delete-button', function () {
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
});

// ============================== |> Module Two <| ============================== //

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
 |  Refresh number of employees
 | ----------------------------------------------------------------
 |
 | Sends ajax request to fetch number of employees
 |
 */
const fetchTotalEmployees = () => {
    $.ajaxSetup({
        headers: {
            'Accepts': 'application/json',
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
        }
    });

    $.ajax({
        type: 'GET',
        url: $('#total-employees-url').data('total-employees-url'),
        success: function (response) {
            if (response.success === true) {
                console.log(response);
                $('.total-employees').text(response.data);
            }
        },
        error: function (xhr, status, error) {
            console.log(xhr);
            console.log(status);
            console.log(error);
        }
    });
}
fetchTotalEmployees();

/**
 | ----------------------------------------------------------------
 |  Show employee errors
 | ----------------------------------------------------------------
 |
 | It accepts the object parameter and shows the input
 | field errors of employee form
 |
 */
const showEmployeeErrors = (response) => {
    $('.error-first-name').html(response.errors.first_name ?? '');
    $('.error-last-name').html(response.errors.last_name ?? '');
    $('.error-phone').html(response.errors.phone ?? '');
    $('.error-email').html(response.errors.email ?? '');
    $('.error-company').html(response.errors.company_id ?? '');
}

/**
 | ----------------------------------------------------------------
 |  Reset employee errors
 | ----------------------------------------------------------------
 |
 | It resets the input field errors of employee form
 |
 */
const resetEmployeeErrors = () => {
    $('.error-first-name').html(null);
    $('.error-last-name').html(null);
    $('.error-phone').html(null);
    $('.error-email').html(null);
    $('.error-company').html(null);
}

/**
 | ----------------------------------------------------------------
 |  Show employee fields
 | ----------------------------------------------------------------
 |
 | It accepts the object parameter and shows the input
 | field data of employee
 |
 */
const showEmployeeFields = (response) => {
    $('#edit-employee .field-first-name').attr('value', response?.data?.first_name);
    $('#edit-employee .field-last-name').attr('value', response?.data?.last_name);
    $('#edit-employee .field-phone').attr('value', response?.data?.phone);
    $('#edit-employee .field-email').attr('value', response?.data?.email);
    $('#edit-employee .field-company').select2().val(response?.data?.company?.id).trigger('change');
}

/**
 | ----------------------------------------------------------------
 |  Reset employee fields
 | ----------------------------------------------------------------
 |
 | It resets the input field of employee form
 |
 */
const resetEmployeeFields = () => {
    $('#create-employee .field-first-name').val(null);
    $('#create-employee .field-last-name').val(null);
    $('#create-employee .field-phone').val(null);
    $('#create-employee .field-email').val(null);
    $('#create-employee .field-company').val(null);
}

/**
 | ----------------------------------------------------------------
 |  Create employee
 | ----------------------------------------------------------------
 |
 | Send ajax request to store employee
 |
 */
$('#create-employee form').submit(function (e) {
    e.preventDefault();

    $.ajaxSetup({
        headers: {
            'Accepts': 'application/json',
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
        }
    });

    $.ajax({
        type: 'POST',
        url: $(this).attr('action'),
        data: $(this).serialize(),
        success: function (response) {
            if (response.success === true) {
                resetEmployeeFields();
                $('#create-employee').modal('hide');
                fetchTotalEmployees();
                employeeTable.ajax.reload();
            } else {
                if (response) {
                    showEmployeeErrors(response);
                }
            }
        },
        error: function (xhr, status, error) {
            console.log(xhr);
            console.log(status);
            console.log(error);
        }
    });
});

/**
 | ----------------------------------------------------------------
 |  Cancel create employee form
 | ----------------------------------------------------------------
 |
 | Remove errors, labels and empty the fields in
 | create employee form
 |
 */
$('.cancel-create-employee-form').click(function () {
    resetEmployeeFields();
    resetEmployeeErrors();
});

/**
 | ----------------------------------------------------------------
 |  Edit employee
 | ----------------------------------------------------------------
 |
 | It shows the edit form and sends ajax request
 | against the specific employee
 |
 */
$('#init-employee-datatable').on('click', '.edit-button', function () {
    $('#edit-employee form').attr('action', $(this).data('update-url'));
    $.ajax({
        type: 'GET',
        url: $(this).data('url'),
        success: function (response) {
            if (response.success === true) {
                showEmployeeFields(response);
                $('#edit-employee').modal('show');
            } else {
                console.log(response);
            }
        },
        error: function (xhr, status, error) {
            console.log(xhr);
            console.log(status);
            console.log(error);
        }
    });
});

/**
 | ----------------------------------------------------------------
 |  Update employee
 | ----------------------------------------------------------------
 |
 | Send ajax request to store employee
 |
 */
$('#edit-employee form').submit(function (e) {
    e.preventDefault();

    $.ajaxSetup({
        headers: {
            'Accepts': 'application/json',
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
        }
    });

    $.ajax({
        type: 'PUT',
        url: $(this).attr('action'),
        data: $(this).serialize(),
        success: function (response) {
            if (response.success === true) {
                console.log(response);
                $('#edit-employee').modal('hide');
                employeeTable.ajax.reload();
            } else {
                showEmployeeErrors(response);
            }
        },
        error: function (xhr, status, error) {
            console.log(xhr);
            console.log(status);
            console.log(error);
        }
    });
});

/**
 | ----------------------------------------------------------------
 |  Cancel edit employee form
 | ----------------------------------------------------------------
 |
 | Remove errors and labels in edit employee form
 |
 */
$('.cancel-edit-employee-form').click(function () {
    resetEmployeeErrors();
});

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
                url: $(this).data('url'),
                success: function (response) {
                    if (response.success == true) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Deleted!',
                            text: response.message
                        })
                        fetchTotalEmployees();
                        employeeTable.ajax.reload();
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...!',
                            text: response.message,
                        })
                    }
                },
                error: function (xhr, status, error) {
                    console.log(xhr);
                    console.log(status);
                    console.log(error);
                }
            });
        }
    })
});

// ============================== |> Module Three <| ============================== //

/**
 | ----------------------------------------------------------------
 |  List of projects
 | ----------------------------------------------------------------
 |
 | Initialize datatable and fetch projects data
 | with server side rendering using ajax
 |
 */
var projectTable = $('#init-project-datatable').DataTable({
    processing: true,
    serverSide: true,
    ajax: {
        type: "GET",
        url: $(this).attr('data-url'),
    },
    columns: [
        { data: 'name', name: 'name' },
        { data: 'client_name', name: 'client_name' },
        { data: 'deadline', name: 'deadline' },
        { data: 'action', name: 'action', orderable: false, searchable: false },
    ]
});

/**
 | ----------------------------------------------------------------
 |  Create project
 | ----------------------------------------------------------------
 |
 | Send ajax request to store project
 |
 */
$('#create-project-form').submit(function (e) {
    e.preventDefault();

    $.ajaxSetup({
        headers: {
            'Accepts': 'application/json',
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $.ajax({
        type: 'POST',
        url: $(this).attr('action'),
        data: $(this).serialize(),
        success: function (response) {
            if (response.success === true) {
                $('.field-name').val(null);
                $('.field-detail').val(null);
                $('.field-client-name').val(null);
                $('.field-total-cost').val(null);
                $('.field-deadline').val(null);
                $('.field-employee-id').val(null);
                $('#create-project-modal').modal('hide');
                projectTable.ajax.reload();
            } else {
                if (response.errors) {
                    $('.error-name').html(response.errors.name);
                    $('.error-detail').html(response.errors.detail);
                    $('.error-client-name').html(response.errors.client_name);
                    $('.error-total-cost').html(response.errors.total_cost);
                    $('.error-deadline').html(response.errors.deadline);
                    $('.error-employee-id').html(response.errors.employee_id);
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
 |  Cancel project form
 | ----------------------------------------------------------------
 |
 | Remove errors, labels and empty the fields
 |
 */
$('.cancel-project-form').click(function () {
    $('.field-name').val(null);
    $('.field-detail').val(null);
    $('.field-client-name').val(null);
    $('.field-total-cost').val(null);
    $('.field-deadline').val(null);
    $('.field-employee-id').val(null);
    // $('.select2-selection__choice').text(null);

    $('.error-name').html(null);
    $('.error-detail').html(null);
    $('.error-client-name').html(null);
    $('.error-total-cost').html(null);
    $('.error-deadline').html(null);
    $('.error-employee-id').html(null);
});

/**
 | ----------------------------------------------------------------
 |  Delete project
 | ----------------------------------------------------------------
 |
 | Send ajax request to delete project and refresh the datatable
 |
 */
$('#init-project-datatable').on('click', '.delete-button', function () {
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
                        projectTable.ajax.reload();
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
