$(document).ready(function() {
    $('.summernote').summernote({
        height: 120
    });
  });

/**
 | ----------------------------------------------------------------
 |  Preloader
 | ----------------------------------------------------------------
 */
$(document).ready(function () {
    $("#preloader").show();

    setTimeout(() => {
        $("#preloader").hide();
    }, 2000);
});

/**
 | ----------------------------------------------------------------
 |  Dark mode
 | ----------------------------------------------------------------
 |
 | Set dark mode status and store in local
 | storage of browser
 |
 */
$(document).ready(function () {
    var darkModeEnabled = localStorage.getItem("darkModeEnabled");

    if (darkModeEnabled === "true") {
        enableDarkMode();
    }

    $('#dark-mode-button').click(function (e) {
        e.preventDefault();

        setTimeout(() => {
            if ($('body').hasClass('dark-mode')) {
                enableDarkMode();
                localStorage.setItem("darkModeEnabled", "true");
                console.log('dark mode enabled');
            } else {
                disableDarkMode();
                localStorage.removeItem('darkModeEnabled');
            }
        }, 500);
    });

    function enableDarkMode() {
        $("body").addClass("dark-mode");
    }

    function disableDarkMode() {
        $("body").removeClass("dark-mode");
    }
});

/**
 | ----------------------------------------------------------------
 |  Fetch user avatar
 | ----------------------------------------------------------------
 |
 | Sends ajax request to get the user avatar image
 |
 */
const fetchUserAvatar = () => {
    $.ajaxSetup({
        headers: {
            'Accepts': 'application/json',
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
        }
    });

    $.ajax({
        url: 'profile/avatar',
        type: 'GET',
        success: function (response) {
            if (response.success === true) {
                if ($('.avatar').length == 0) {
                    $('.user-avatar').html('<img class="avatar" src="' + response.data + '" alt="user avatar" />')
                    $('.name-initials').hide();
                }
                $('.avatar').attr('src', response.data);
            } else {
                console.log(response);
            }
        }
    });
}
fetchUserAvatar();

/**
 | ----------------------------------------------------------------
 |  Save user avatar
 | ----------------------------------------------------------------
 |
 | Sends ajax request to store the user avatar image
 |
 */
$('#upload-button-avatar').click(function (e) {
    e.preventDefault();
    $('#avatarInput').click();
    var url = $(this).data('url');

    $('#avatarInput').change(function () {
        if (this.files[0]) {
            var formData = new FormData();
            formData.append('avatar', this.files[0]);

            $.ajaxSetup({
                headers: {
                    'Accepts': 'application/json',
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                url: url,
                type: 'POST',
                data: formData,
                contentType: false,
                processData: false,
                success: function (response, status, error) {
                    if (response.success === true) {
                        toastr['success']('Successfully', 'Avatar Uploaded', {
                            closeButton: true,
                            progressBar: true,
                            tapToDismiss: false,
                            positionClass: 'toast-top-right',
                        });
                        toastr.options.preventDuplicates = true;
                        fetchUserAvatar();
                    } else {
                        if (response) {
                            console.log(response);
                        }
                    }
                },
                error: function (xhr, status, error) {
                    console.log(xhr);
                    console.log(status);
                    console.log(error);
                }
            });
        }
    });
});

/**
 | ----------------------------------------------------------------
 |  Fetch user profile
 | ----------------------------------------------------------------
 |
 | Sends ajax request to get the user profile information
 |
 */
const fetchUserProfile = () => {
    $.ajaxSetup({
        headers: {
            'Accepts': 'application/json',
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
        }
    });

    $.ajax({
        url: 'profile',
        type: 'GET',
        success: function (response) {
            if (response.success === true) {
                $('.profile-name').html(response?.data?.name);
                $('.profile-display-name').html(response?.data?.display_name);
                $('.profile-email').html(response?.data?.email);
                $('.profile-phone').html(response?.data?.phone);
                $('.profile-gender').html(response?.data?.gender);
                $('.profile-date-of-birth').html(response?.data?.date_of_birth);
                $('.profile-address').html(response?.data?.full_address);
            } else {
                console.log(response);
            }
        }
    });
}
fetchUserProfile();

/**
 | ----------------------------------------------------------------
 |  Update profile personal information
 | ----------------------------------------------------------------
 |
 | Send ajax request to update user profile
 | personal information
 |
 */
$('#display-name-switch').change(function () {
    const displayName = $('#edit-profile .field-display-name').attr('value');
    if ($(this).is(':checked')) {
        $('#edit-profile .field-display-name').val($('#edit-profile .field-name').val());
    } else {
        $('#edit-profile .field-display-name').val(displayName ?? null);
    }
});

$('#edit-profile form').submit(function (e) {
    e.preventDefault();

    $.ajaxSetup({
        headers: {
            'Accepts': 'application/json',
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $.ajax({
        url: $(this).attr('action'),
        type: 'PATCH',
        data: $(this).serialize(),
        success: function (response) {
            if (response.success === true) {
                $('#edit-profile').modal('hide');
                fetchUserProfile();
            } else {
                $('#edit-profile .error-name').html(response.errors.name);
                $('#edit-profile .error-display-name').html(response.errors.display_name);
                $('#edit-profile .error-phone').html(response.errors.phone);
                $('#edit-profile .error-gender').html(response.errors.gender);
                $('#edit-profile .error-date-of-birth').html(response.errors.date_of_birth);
            }
        },
        error: function (xhr, status, error) {
            console.log(xhr);
            console.log(status);
            console.log(error);
        }
    });
})

/**
 | ----------------------------------------------------------------
 |  Update profile address
 | ----------------------------------------------------------------
 |
 | Send ajax request to update user profile
 | address
 |
 */
$('#edit-profile-address').submit(function (e) {
    e.preventDefault();

    $.ajaxSetup({
        headers: {
            'Accepts': 'application/json',
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $.ajax({
        url: $(this).attr('action'),
        type: 'PATCH',
        data: $(this).serialize(),
        success: function (response) {
            if (response.success === true) {
                $('#edit-profile').modal('hide');
                fetchUserProfile();
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
 |  Update password
 | ----------------------------------------------------------------
 |
 | It verify current password then update new password
 |
 */
$('#security-settings').submit(function (e) {
    e.preventDefault();

    $.ajax({
        url: $(this).attr('action'),
        type: 'PUT',
        data: $(this).serialize(),
        success: function (response) {
            if (response.success === true) {
                $('#security-settings .error-current-password').html(null);
                $('#security-settings .error-new-password').html(null);
                $('#security-settings #current_password').val(null);
                $('#security-settings #password').val(null);
                $('#security-settings #password_confirmation').val(null);
                toastr['success']('Successfully', response.message, {
                    closeButton: true,
                    progressBar: true,
                    tapToDismiss: false,
                    positionClass: 'toast-top-right',
                });
                toastr.options.preventDuplicates = true;
            } else {
                $('#security-settings .error-current-password').html(response.errors.current_password ?? null);
                $('#security-settings .error-new-password').html(response.errors.password ?? null);
            }
        }
    });
});


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
        url: $(this).data('url'),
    },
    columns: [
        { data: 'logo', name: 'logo', orderable: false },
        { data: 'name', name: 'name' },
        { data: 'email', name: 'email' },
        { data: 'website', name: 'website' },
        { data: 'action', name: 'action', orderable: false, searchable: false },
    ]
});

/**
 | ----------------------------------------------------------------
 |  Refresh number of companies
 | ----------------------------------------------------------------
 |
 | Sends ajax request to fetch number of companies
 |
 */
const fetchTotalCompanies = () => {
    $.ajaxSetup({
        headers: {
            'Accepts': 'application/json',
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
        }
    });

    $.ajax({
        type: 'GET',
        url: $('#total-companies-url').data('total-companies-url'),
        success: function (response) {
            if (response.success === true) {
                $('.total-companies').text(response.data);
            }
        },
        error: function (xhr, status, error) {
            console.log(xhr);
            console.log(status);
            console.log(error);
        }
    });
}
fetchTotalCompanies();

/**
 | ----------------------------------------------------------------
 |  Show company errors
 | ----------------------------------------------------------------
 |
 | It accepts the object parameter and shows the input
 | field errors of company form
 |
 */
const showCompanyErrors = (response) => {
    $('.error-logo').html(response.errors.logo ?? '');
    $('.error-name').html(response.errors.name ?? '');
    $('.error-email').html(response.errors.email ?? '');
    $('.error-website').html(response.errors.website ?? '');
}

/**
 | ----------------------------------------------------------------
 |  Reset company errors
 | ----------------------------------------------------------------
 |
 | It resets the input field errors of company form
 |
 */
const resetCompanyErrors = () => {
    $('.error-logo').html(null);
    $('.error-name').html(null);
    $('.error-email').html(null);
    $('.error-website').html(null);
}

/**
 | ----------------------------------------------------------------
 |  Show company fields
 | ----------------------------------------------------------------
 |
 | It accepts the object parameter and shows the input
 | field data of company
 |
 */
const showCompanyFields = (response) => {
    $('#edit-company .field-logo').val(response?.data?.logo);
    $('#edit-company .field-name').val(response?.data?.name);
    $('#edit-company .field-email').val(response?.data?.email);
    $('#edit-company .field-website').val(response?.data?.website);
}

/**
 | ----------------------------------------------------------------
 |  Reset company fields
 | ----------------------------------------------------------------
 |
 | It resets the input field of company form
 |
 */
const resetCompanyFields = () => {
    $('#create-company .custom-file-label').html(null);
    $('#create-company .field-logo').val(null);
    $('#create-company .field-name').val(null);
    $('#create-company .field-email').val(null);
    $('#create-company .field-website').val(null).trigger('change');
}

/**
 | ----------------------------------------------------------------
 |  Create company
 | ----------------------------------------------------------------
 |
 | Send ajax request to store company
 |
 */
$('#create-company form').submit(function (e) {
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
                resetCompanyFields();
                resetCompanyErrors();
                $('#create-company').modal('hide');
                fetchTotalCompanies();
                compantTable.ajax.reload();
            } else {
                if (response.errors) {
                    showCompanyErrors(response);
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
 |  Cancel create company form
 | ----------------------------------------------------------------
 |
 | Remove errors, labels and empty the fields
 |
 */
$('.cancel-create-company-form').click(function () {
    resetCompanyFields();
    resetCompanyErrors();
});

/**
 | ----------------------------------------------------------------
 |  Edit company
 | ----------------------------------------------------------------
 |
 | It shows the edit form and sends ajax request
 | against the specific company
 |
 */
$('#init-company-datatable').on('click', '.edit-button', function () {
    $('#edit-company form').attr('action', $(this).data('update-url'));
    $.ajax({
        type: 'GET',
        url: $(this).data('url'),
        success: function (response) {
            if (response.success === true) {
                showCompanyFields(response);
                $('#edit-company').modal('show');
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
 |  Update company
 | ----------------------------------------------------------------
 |
 | Send ajax request to update company
 |
 */
$('#edit-company form').submit(function (e) {
    e.preventDefault();

    $.ajaxSetup({
        headers: {
            'Accepts': 'application/json',
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            'X-HTTP-Method-Override': 'PUT'
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
                resetCompanyErrors();
                $('#edit-company').modal('hide');
                compantTable.ajax.reload();
            } else {
                console.log(response);
                showCompanyErrors(response);
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
 |  Cancel edit company form
 | ----------------------------------------------------------------
 |
 | Remove errors
 |
 */
$('.cancel-edit-company-form').click(function () {
    resetCompanyErrors();
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
                        fetchTotalCompanies();
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
        url: $('#init-employee-datatable').data('url'),
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
    $('#edit-employee .field-first-name').val(response?.data?.first_name);
    $('#edit-employee .field-last-name').val(response?.data?.last_name);
    $('#edit-employee .field-phone').val(response?.data?.phone);
    $('#edit-employee .field-email').val(response?.data?.email);
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
    $('#create-employee .field-company').val(null).trigger('change');
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
                resetEmployeeErrors();
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
                $('#edit-employee').modal('show');
                showEmployeeFields(response);
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
                resetEmployeeErrors();
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
 |  Refresh number of projects
 | ----------------------------------------------------------------
 |
 | Sends ajax request to fetch number of projects
 |
 */
const fetchTotalProjects = () => {
    $.ajaxSetup({
        headers: {
            'Accepts': 'application/json',
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
        }
    });

    $.ajax({
        type: 'GET',
        url: $('#total-projects-url').data('total-projects-url'),
        success: function (response) {
            if (response.success === true) {
                $('.total-projects').text(response.data);
            }
        },
        error: function (xhr, status, error) {
            console.log(xhr);
            console.log(status);
            console.log(error);
        }
    });
}
fetchTotalProjects();

/**
 | ----------------------------------------------------------------
 |  Show project errors
 | ----------------------------------------------------------------
 |
 | It accepts the object parameter and shows the input
 | field errors of project form
 |
 */
const showProjectErrors = (response) => {
    $('.error-name').html(response.errors.name ?? '');
    $('.error-detail').html(response.errors.detail ?? '');
    $('.error-client-name').html(response.errors.client_name ?? '');
    $('.error-total-cost').html(response.errors.total_cost ?? '');
    $('.error-deadline').html(response.errors.deadline ?? '');
    $('.error-employee-id').html(response.errors.employee_id ?? '');
}

/**
 | ----------------------------------------------------------------
 |  Reset project errors
 | ----------------------------------------------------------------
 |
 | It resets the input field errors of project form
 |
 */
const resetProjectErrors = () => {
    $('.error-name').html(null);
    $('.error-detail').html(null);
    $('.error-client-name').html(null);
    $('.error-total-cost').html(null);
    $('.error-deadline').html(null);
    $('.error-project-id').html(null);
}

/**
 | ----------------------------------------------------------------
 |  Show project fields
 | ----------------------------------------------------------------
 |
 | It accepts the object parameter and shows the input
 | field data of project
 |
 */
const showProjectFields = (response) => {
    $('#edit-project .field-name').val(response?.data?.name);
    $('#edit-project .field-detail').html(response?.data?.detail);
    $('#edit-project .field-client-name').val(response?.data?.client_name);
    $('#edit-project .field-total-cost').val(response?.data?.total_cost);
    $('#edit-project .field-deadline').val(changeDateFormat(response?.data?.deadline));
    var employeeIds = [];
    response.data.employees.map(function (item) {
        employeeIds.push(item.id);
    });
    $('#edit-project .field-employee-id').select2().val(employeeIds).trigger('change');
}

/**
 | ----------------------------------------------------------------
 |  Reset project fields
 | ----------------------------------------------------------------
 |
 | It resets the input field of project form
 |
 */
const resetProjectFields = () => {
    $('#create-project .field-name').val(null);
    $('#create-project .field-detail').val(null);
    $('#create-project .field-client-name').val(null);
    $('#create-project .field-total-cost').val(null);
    $('#create-project .field-deadline').val(null);
    $('#create-project .field-employee-id').select2().val(null).trigger('change');
}

/**
 | ----------------------------------------------------------------
 |  Create project
 | ----------------------------------------------------------------
 |
 | Send ajax request to store project
 |
 */
$('#create-project form').submit(function (e) {
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
                resetProjectFields();
                $('#create-project').modal('hide');
                fetchTotalProjects();
                projectTable.ajax.reload();
            } else {
                if (response.errors) {
                    showProjectErrors(response);
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
 |  Cancel create project form
 | ----------------------------------------------------------------
 |
 | Remove errors, labels and empty the fields
 |
 */
$('.cancel-create-project-form').click(function () {
    resetProjectFields();
    resetProjectErrors();
});

/**
 | ----------------------------------------------------------------
 |  Change the format of date
 | ----------------------------------------------------------------
 |
 | It changes the date format and return as ISO 8601
 |
 */
const changeDateFormat = (date) => {
    var date = new Date(date);
    return date.getFullYear() + '-' + ('0' + (date.getMonth() + 1)).slice(-2) + '-' + ('0' + date.getDate()).slice(-2);
}

/**
 | ----------------------------------------------------------------
 |  Edit project
 | ----------------------------------------------------------------
 |
 | It shows the edit form and sends ajax request
 | against the specific project
 |
 */
$('#init-project-datatable').on('click', '.edit-button', function () {
    $('#edit-project form').attr('action', $(this).data('update-url'));
    $.ajax({
        type: 'GET',
        url: $(this).data('url'),
        success: function (response) {
            if (response.success === true) {
                showProjectFields(response);
                $('#edit-project').modal('show');
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
 |  Update project
 | ----------------------------------------------------------------
 |
 | Send ajax request to store project
 |
 */
$('#edit-project form').submit(function (e) {
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
                resetProjectErrors();
                $('#edit-project').modal('hide');
                projectTable.ajax.reload();
            } else {
                showProjectErrors(response);
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
 |  Cancel edit project form
 | ----------------------------------------------------------------
 |
 | Remove errors and labels in edit project form
 |
 */
$('.cancel-edit-project-form').click(function () {
    resetProjectErrors();
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
                url: $(this).data('url'),
                success: function (response) {
                    if (response.success == true) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Deleted!',
                            text: response.message
                        })
                        fetchTotalProjects();
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
