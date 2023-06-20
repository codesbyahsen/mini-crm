// ============================== |> Global <| ============================== //

/**
 | ----------------------------------------------------------------
 |  Initialize summernote
 | ----------------------------------------------------------------
 */
$(document).ready(function () {
    $('.summernote').summernote({
        height: 120,
        toolbar: [
            ['style', ['style']],
            ['font', ['bold', 'italic', 'underline', 'strikethrough', 'clear']],
            ['fontname', ['fontname']],
            ['fontsize', ['fontsize']],
            ['color', ['color']],
            ['para', ['ol', 'ul', 'paragraph', 'height']],
            ['table', ['table']],
            ['view', ['fullscreen', 'codeview', 'help']]
        ]
    });
});

/**
 | ----------------------------------------------------------------
 |  Change the format of date
 | ----------------------------------------------------------------
 |
 | It changes the date format and return as ISO 8601 formated
 |
 */
const changeDateFormat = (date, format = 'iso-8601') => {
    var date = new Date(date);

    if (format == 'iso-8601') {
        return date.getFullYear() + '-' + ('0' + (date.getMonth() + 1)).slice(-2) + '-' + ('0' + date.getDate()).slice(-2);
    } else {
        return date.toLocaleDateString();
    }
}

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
 |  Generate random string
 | ----------------------------------------------------------------
 |
 | It generate rondom string use for multi purpose
 |
 */
const random = (length = 12) => {
    let chars = "0123456789abcdefghijklmnopqrstuvwxyz!@#$%^&_ABCDEFGHIJKLMNOPQRSTUVWXYZ";
    let randomString = '';

    for (var i = 0; i <= length; i++) {
        let randomNumber = Math.floor(Math.random() * chars.length);
        randomString += chars.substring(randomNumber, randomNumber + 1);
    }
    return randomString;
}

/**
 | ----------------------------------------------------------------
 |  Copy to clipboard
 | ----------------------------------------------------------------
 |
 | It writes the data on clipboard to available for reuse
 | by pasting
 |
 */
const copyToClipboard = (data) => {
    navigator.clipboard.writeText(data);
}

/**
 | ----------------------------------------------------------------
 |  Get random string as a password
 | ----------------------------------------------------------------
 |
 | It shows random string for password generating modal
 |
 */
$(document).ready(function () {
    $('#get-random-password').val(random());
});

$('#generate-password').click(function (e) {
    $('#get-random-password').val(random());
});

/**
 | ----------------------------------------------------------------
 |  Copy input from "generate random password modal"
 | ----------------------------------------------------------------
 |
 | It takes the value for copy from generate random password
 | modal
 |
 */
$('#get-random-password').click(function () {
    let value = $('#get-random-password').val();
    copyToClipboard(value);
    toastr['success']('', 'Copied to clipboard!');
});


// ============================== |> User Profile Module <| ============================== //

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
                $('.profile-name').html((response?.data?.name) ? (response?.data?.name) : (response?.data?.first_name + ' ' + response?.data?.last_name));
                if (response?.data?.display_name) {
                    $('.profile-display-name').html(response?.data?.display_name);
                } else {
                    $('.profile-display-name').html(response.data.name ?? response.data.first_name + ' ' + response.data.last_name);
                }
                $('.profile-email').html(response?.data?.email);
                $('.profile-phone').html(response?.data?.phone ?? 'Not added yet');
                if (response?.data?.hasOwnProperty('gender')) {
                    $('.profile-gender').html(response?.data?.gender ?? 'Not added yet');
                } else {
                    $('.profile-founded-in').html(response?.data?.founded_in ?? 'Not added yet');
                }
                if (response?.data?.hasOwnProperty('date_of_birth')) {
                    $('.profile-date-of-birth').html(response?.data?.date_of_birth ?? 'Not added yet');
                } else {
                    $('.profile-website').html(response?.data?.website ?? 'Not added yet');
                }
                $('.profile-address').html(response?.data?.full_address ?? 'Not added yet');
            } else {
                console.log(response);
            }
        }
    });
}
fetchUserProfile();

/**
 | ----------------------------------------------------------------
 |  Clear password fields error
 | ----------------------------------------------------------------
 |
 | When click on personal profile tab it will clear the
 | password fields error
 |
 */
$('.tab-profile-settings').click(function (e) {
    e.preventDefault();

    $('#security-settings .error-current-password').html(null);
    $('#security-settings .error-new-password').html(null);
});

/**
 | ----------------------------------------------------------------
 |  Show personal profile errors
 | ----------------------------------------------------------------
 |
 | It accepts the object parameter and shows the input
 | field errors of user profile personal information
 |
 */
const showPersonalProfileErrors = (response) => {
    if (response?.errors?.name) {
        $('#edit-profile .error-name').html(response.errors.name ?? null);
    } else {
        $('#edit-profile .error-first-name').html(response.errors.first_name ?? null);
        $('#edit-profile .error-last-name').html(response.errors.last_name ?? null);
    }

    $('#edit-profile .error-display-name').html(response.errors.display_name ?? null);
    $('#edit-profile .error-phone').html(response.errors.phone ?? null);

    if (response?.errors?.hasOwnProperty('gender')) {
        $('#edit-profile .error-gender').html(response.errors.gender ?? null);
    } else {
        $('#edit-profile .error-founded-in').html(response.errors.founded_in ?? null);
    }

    if (response?.errors?.hasOwnProperty('date_of_birth')) {
        $('#edit-profile .error-date-of-birth').html(response.errors.date_of_birth ?? null);
    } else {
        $('#edit-profile .error-website').val(response.errors.website ?? null);
    }
}

/**
 | ----------------------------------------------------------------
 |  Reset personal profile errors
 | ----------------------------------------------------------------
 |
 | It resets the input field errors of personal user profile form
 |
 */
const resetPersonalProfileErrors = () => {
    $('#edit-profile .error-name').html(null);
    $('#edit-profile .error-first-name').html(null);
    $('#edit-profile .error-last-name').html(null);
    $('#edit-profile .error-display-name').html(null);
    $('#edit-profile .error-phone').html(null);
    $('#edit-profile .error-gender').html(null);
    $('#edit-profile .error-date-of-birth').html(null);
    $('#edit-profile .error-founded-in').html(null);
    $('#edit-profile .error-website').val(null);
}

/**
 | ----------------------------------------------------------------
 |  Show profile address errors
 | ----------------------------------------------------------------
 |
 | It accepts the object parameter and shows the input
 | field errors of user profile address
 |
 */
const showProfileAddressErrors = (response) => {
    $('#edit-profile-address .error-address-line-one').html(response.errors.address_line_one ?? null);
    $('#edit-profile-address .error-address-line-two').html(response.errors.address_line_two ?? null);
    $('#edit-profile-address .error-city').html(response.errors.city ?? null);
    $('#edit-profile-address .error-state').html(response.errors.state ?? null);
    $('#edit-profile-address .error-country').html(response.errors.date_of_birth ?? null);
}

/**
 | ----------------------------------------------------------------
 |  Reset profile address errors
 | ----------------------------------------------------------------
 |
 | It resets the input field errors of user profile address form
 |
 */
const resetProfileAddressErrors = () => {
    $('#edit-profile-address .error-address-line-one').html(null);
    $('#edit-profile-address .error-address-line-two').html(null);
    $('#edit-profile-address .error-city').html(null);
    $('#edit-profile-address .error-state').html(null);
    $('#edit-profile-address .error-country').html(null);
}

/**
 | ----------------------------------------------------------------
 |  Show profile all fields
 | ----------------------------------------------------------------
 |
 | It accepts the object parameter and shows the all input
 | fields data of user profile
 |
 */
const showProfileFields = (response) => {
    if (response?.data?.name) {
        $('#edit-profile .field-name').val(response?.data?.name);
    } else {
        $('#edit-profile .field-first-name').val(response?.data?.first_name);
        $('#edit-profile .field-last-name').val(response?.data?.last_name);
    }
    $('#edit-profile .field-display-name').val(response?.data?.display_name);
    $('#edit-profile .field-display-name').attr('value', response?.data?.display_name);
    $('#edit-profile .field-phone').val(response?.data?.phone);
    if (response?.data?.hasOwnProperty('gender')) {
        $('#edit-profile .field-gender').val(response?.data?.gender).trigger('change');
    } else {
        $('#edit-profile .field-founded-in').val(response?.data?.founded_in);
    }
    if (response?.data?.hasOwnProperty('date_of_birth')) {
        $('#edit-profile .field-date-of-birth').val(response?.data?.date_of_birth);
    } else {
        $('#edit-profile .field-website').val(response?.data?.website);
    }
    $('#edit-profile .field-address-line-one').val(response?.data?.address_line_one);
    $('#edit-profile .field-address-line-two').val(response?.data?.address_line_two);
    $('#edit-profile .field-city').val(response?.data?.city);
    $('#edit-profile .field-state').val(response?.data?.state);
    $('#edit-profile .field-country').val(response?.data?.country).trigger('change');
}

/**
 | ----------------------------------------------------------------
 |  Edit profile
 | ----------------------------------------------------------------
 |
 | It shows the edit form and sends ajax request
 | against the specific profile
 |
 */
$('#user-profile').click(function () {
    $.ajax({
        url: $(this).data('url'),
        type: 'GET',
        success: function (response) {
            if (response.success === true) {
                showProfileFields(response);
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
                resetPersonalProfileErrors();
                resetProfileAddressErrors();
                fetchUserProfile();
            } else {
                showPersonalProfileErrors(response);
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
                resetPersonalProfileErrors();
                resetProfileAddressErrors();
                fetchUserProfile();
            } else {
                showProfileAddressErrors(response);
            }
        },
        error: function (xhr, status, error) {
            console.log(xhr);
            console.log(status);
            console.log(error);
        }
    });
});

$('.cancel-edit-profile-modal').click(function (e) {
    e.preventDefault();

    resetPersonalProfileErrors();
    resetProfileAddressErrors();
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
                toastr.options.preventDuplicates = true;
                toastr['success']('Successfully', response.message, {
                    closeButton: true,
                    progressBar: true,
                    tapToDismiss: false,
                    positionClass: 'toast-top-right',
                });
            } else {
                $('#security-settings .error-current-password').html(response.errors.current_password ?? null);
                $('#security-settings .error-new-password').html(response.errors.password ?? null);
            }
        }
    });
});


// ============================== |> Company Module <| ============================== //

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
    dom: "<'row'<'col-sm-12 col-md-6 float-left'f><'col-sm-12 col-md-6'<'float-right'l>>>" + "<'row'<'col-sm-12'tr>>" + "<'row'<'col-sm-12 col-md-7 float-left'p><'col-sm-12 col-md-5'<'float-right'i>>>",
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
    $('.error-password').html(response.errors.password ?? '');
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
    $('.error-password').html(null);
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
    $('#edit-company .display-company-logo').attr('src', response?.data?.logo);
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
                $('#create-company').modal('hide');
                resetCompanyFields();
                resetCompanyErrors();
                fetchTotalCompanies();
                compantTable.ajax.reload();
            } else {
                if (response.errors) {
                    showCompanyErrors(response);
                } else {
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
});

/**
 | ----------------------------------------------------------------
 |  Make create company modal scrollable
 | ----------------------------------------------------------------
 |
 | When opens a modal on modal it prevent the scrolling for
 | main modal so it make main modal scrollable again
 |
 */
$(document).on('hidden.bs.modal', function (event) {
    if ($('#create-company:visible').length) {
        $('body').addClass('modal-open');
    }
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
                $('#edit-company').modal('show');
                showCompanyFields(response);
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
                $('#edit-company').modal('hide');
                resetCompanyErrors();
                compantTable.ajax.reload();
            } else {
                if (response.errors) {
                    showCompanyErrors(response);
                } else {
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

// ============================== |> Employee Module <| ============================== //

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
    dom: "<'row'<'col-sm-12 col-md-6 float-left'f><'col-sm-12 col-md-6'<'float-right'l>>>" + "<'row'<'col-sm-12'tr>>" + "<'row'<'col-sm-12 col-md-7 float-left'p><'col-sm-12 col-md-5'<'float-right'i>>>",
    ajax: {
        type: "GET",
        url: $('#init-employee-datatable').data('url'),
    },
    columns: [
        { data: 'fullname', name: 'fullname' },
        { data: 'email', name: 'email' },
        { data: 'phone', name: 'phone' },
        { data: 'company.name', name: 'company.name' },
        { data: 'action', name: 'action', orderable: false, searchable: false }
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
    $('.error-password').html(response.errors.password ?? '');
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
    $('.error-password').html(null);
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
    $('#edit-employee .display-employee-avatar').attr('src', response?.data?.avatar);
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
    $('#create-employee .field-password').val(null);
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
                $('#create-employee').modal('hide');
                resetEmployeeErrors();
                resetEmployeeFields();
                fetchTotalEmployees();
                employeeTable.ajax.reload();
            } else {
                if (response.errors) {
                    showEmployeeErrors(response);
                } else {
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
});

/**
 | ----------------------------------------------------------------
 |  Make create employee modal scrollable
 | ----------------------------------------------------------------
 |
 | When opens a modal on modal it prevent the scrolling for
 | main modal so it make main modal scrollable again
 |
 */
$(document).on('hidden.bs.modal', function (event) {
    if ($('#create-employee:visible').length) {
        $('body').addClass('modal-open');
    }
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
                $('#edit-employee').modal('hide');
                resetEmployeeErrors();
                employeeTable.ajax.reload();
            } else {
                if (response.errors) {
                    showEmployeeErrors(response);
                } else {
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
    $('#edit-employee .field-password').val(null);
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

// ============================== |> Project Module <| ============================== //

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
    dom: "<'row'<'col-sm-12 col-md-6 float-left'f><'col-sm-12 col-md-6'<'float-right'l>>>" + "<'row'<'col-sm-12'tr>>" + "<'row'<'col-sm-12 col-md-7 float-left'p><'col-sm-12 col-md-5'<'float-right'i>>>",
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
    $('#edit-project .field-detail').html(response?.data?.detail).summernote('code', response?.data?.detail);
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
    $('#create-project .field-detail').summernote('reset');
    $('#create-project .field-client-name').val(null);
    $('#create-project .field-total-cost').val(null);
    $('#create-project .field-deadline').val(null);
    $('#create-project .field-employee-id').select2().val(null).trigger('change');
}

/**
 | ----------------------------------------------------------------
 |  Show project attributes
 | ----------------------------------------------------------------
 |
 | It accepts the object parameter and shows the attributes
 | of project
 |
 */
const showProjectAttributes = (response) => {
    $('.show-name').html(response?.data?.name);
    $('.show-client-name').html(response?.data?.client_name);
    $('.show-total-cost').html(response?.data?.total_cost);
    $('.show-deadline').html(response?.data?.deadline);
    $('.show-detail').html(response?.data?.detail);
    var employees = response?.data?.employees;
    employees.map(function (employee, index) {
        $('.show-employees').append(employee?.first_name + ' ' + employee.last_name + ((employees.length - 1) == index ? '.' : ', '));
    });
    $('.show-company').html(response?.data?.detail);
}

/**
 | ----------------------------------------------------------------
 |  Reset project attributes
 | ----------------------------------------------------------------
 |
 | It resets the attributes of project
 |
 */
const resetProjectAttributes = () => {
    $('.show-name').html(null);
    $('.show-client-name').html(null);
    $('.show-total-cost').html(null);
    $('.show-deadline').html(null);
    $('.show-detail').html(null);
    $('.show-employees').html(null);
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
                $('#create-project').modal('hide');
                resetProjectFields();
                resetProjectErrors();
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
 |  Show project
 | ----------------------------------------------------------------
 |
 | It shows the show project details and sends ajax request
 | against the specific project
 |
 */
$('#init-project-datatable').on('click', '.view-details-button', function () {
    $.ajax({
        type: 'GET',
        url: $(this).data('show-url'),
        success: function (response) {
            if (response.success === true) {
                showProjectAttributes(response);
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
 |  Close the view of project
 | ----------------------------------------------------------------
 |
 | It reset the html of the attributes when click on close
 | modal
 |
 */
$('.close-view-project').click(function () {
    resetProjectAttributes();
});

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
                $('#edit-project').modal('hide');
                resetProjectErrors();
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
