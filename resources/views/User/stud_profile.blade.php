@extends('Layout/student_master')

@section('title', 'Profile')

@section('content')
<style>
.profile_picture{
width:70px;
height:70px;
border-radius: 50%;
border:2px white solid;
}

/* Override SweetAlert2 default styles */
.swal2-popup {
    font-family: 'Roboto', sans-serif; /* Set the font family for the modal */
}

/* Style the title */
.swal2-title {
    font-size: 24px; /* Set the font size for the title */
    color: #000000; /* Set the color for the title */
    font-weight: 500; /* Set the font weight for the title */
    margin-bottom: 10px; /* Add margin to the bottom of the title */
}

/* Style the content */
.swal2-content {
    font-size: 16px; /* Set the font size for the content */
    color: #000000; /* Set the color for the content */
    font-weight: 400; /* Set the font weight for the content */
    margin-bottom: 20px; /* Add margin to the bottom of the content */
}

/* Style the buttons */
.swal2-confirm,
.swal2-cancel {
    font-size: 16px; /* Set the font size for the buttons */
    padding: 10px 20px; /* Add padding to the buttons */
    margin: 5px; /* Add margin to the buttons */
}

/* Style the success icon */
.swal2-icon.swal2-success .swal2-success-ring {
    border: 4px solid #4CAF50; /* Set the border color for the success ring */
}

/* Style the success icon */
.swal2-icon.swal2-success .swal2-success-fix {
    border-color: #4CAF50; /* Set the border color for the success icon */
}

.profile_output span {
    text-transform: capitalize; /* Capitalize the text */
}

</style>
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<h1 class="stud_title">Profile</h1>
<u><p class="stud_subtitle">Edit Profile</p></u>
<div class="profile-big-container">
<div class="profile-container">
    <div class="profile-data_top" onclick="editProfile('profile_picture')">
        <div class="profile-label">
        <img class= profile_picture src="{{ $student->profile_picture ? url($student->profile_picture) : asset('storage/' )}}" alt="Profile Picture" data-field="profile_picture">
        {{-- <label class="profile-label">Profile Picture</label> --}}
        <!-- Display profile picture -->
        </div>
        <div class= "profile_output">
            <p class=profile_txt>Change Profile Picture</p>
            <button class="edit-button"></button>
        </div>
    </div>
    

    
   <!-- Add an identifier (e.g., data-field="email") to each profile data span -->
<div class="profile-data">
    <label class="profile-label">Email</label>
    <div class= "profile_output_email">
    <span data-field="email">{{ $student->email }}</span>
    </div>
</div>


    <div class="profile-data" onclick="editProfile('Name')">
        <label class="profile-label">Name</label>
        <div class= "profile_output">
        <span data-field="name">{{ $student->name }}</span>
        <button class="edit-button"></button>
        </div>
    </div>


    <div class="profile-data" onclick="editProfile('Gender')">
        <label class="profile-label">Gender</label>
        <div class= "profile_output">
        <span data-field="gender">{{ $student->gender }}</span>
        <button class="edit-button"></button>
        </div>
    </div>

    <div class="profile-data" onclick="editProfile('dob')">
        <label class="profile-label">Date of Birth</label>
        <div class= "profile_output">
            <span data-field="dob">{{ $student->dob }}</span>
            <button class="edit-button"></button>
        </div>
    </div>

    <div class="profile-data_low" onclick="editPassword()">
        <label class="profile-label">Password</label>
        <div class= "profile_output">
        <span data-field="password">Change New Password</span>
        <button class="edit-button"></button>
        </div>
    </div>
    <!-- Add more fields as needed -->

</div>

<div class="profile-data_logout" onclick="confirmLogout()">
        <label class="profile-label_logout">Log Out</label>
        <button class="logout-button"></button>
</div>
</div>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
   function editProfile(field) {
        if (field == 'profile_picture') {
            // Handle profile picture editing
            var input = document.createElement('input');
            input.type = 'file';
            input.accept = 'image/*';

            input.addEventListener('change', function () {
                var file = input.files[0];
                if (file) {
                    var formData = new FormData();
                    formData.append('profile_picture', file);
                    formData.append('_token', '{{ csrf_token() }}');

                    $.ajax({
                        url: "{{ route('upload_profile_picture') }}",
                        method: 'POST',
                        data: formData,
                        contentType: false,
                        processData: false,
                        success: function (response) {
                            if (response.success) {
                                document.querySelector('.profile-data_top img[data-field="profile_picture"]').src = response.url + '?timestamp=' + new Date().getTime();
                                showSuccessAlert('Profile picture uploaded successfully!');
                            } else {
                                showErrorAlert('Error uploading profile picture');
                            }
                        },
                        error: function () {
                            showErrorAlert('Error uploading profile picture');
                        },
                    });
                }
            });

            input.click();
        } else {
            // Handle other field editing
            if (field.toLowerCase() === 'gender') {
                // For the gender field, show a dropdown
                Swal.fire({
                    title: 'Select Gender',
                    input: 'select',
                    inputOptions: {
                        'male': 'Male',
                        'female': 'Female'
                    },
                    showCancelButton: true,
                    confirmButtonText: 'Save',
                    showLoaderOnConfirm: true,
                    preConfirm: (value) => {
                        return $.ajax({
                            url: "{{ route('update_profile') }}",
                            method: 'POST',
                            data: {
                                field: field.toLowerCase(),
                                value: value,
                                _token: '{{ csrf_token() }}',
                            },
                            success: function (response) {
                                if (response.success) {
                                    document.querySelector('.profile-data span[data-field="' + field.toLowerCase() + '"]').innerText = value;
                                    showSuccessAlert('Profile updated successfully!');
                                } else {
                                    showErrorAlert('Error updating profile');
                                }
                            },
                            error: function () {
                                showErrorAlert('Error updating profile');
                            },
                        });
                    },
                    allowOutsideClick: () => !Swal.isLoading(),
                }).then((result) => {
                    if (result.isConfirmed) {
                        showSuccessAlert('Profile updated successfully!');
                    }
                });
            } else if (field.toLowerCase() === 'dob') {
                // For the dob field, show a date picker
                Swal.fire({
                    title: 'Select Date of Birth',
                    input: 'date',  // Use the 'date' type here
                    inputValue: '{{ $student->dob }}',
                    showCancelButton: true,
                    confirmButtonText: 'Save',
                    showLoaderOnConfirm: true,
                    preConfirm: (value) => {
                        return $.ajax({
                            url: "{{ route('update_profile') }}",
                            method: 'POST',
                            data: {
                                field: field.toLowerCase(),
                                value: value,
                                _token: '{{ csrf_token() }}',
                            },
                            success: function (response) {
                                if (response.success) {
                                    document.querySelector('.profile-data span[data-field="' + field.toLowerCase() + '"]').innerText = value;
                                    showSuccessAlert('Profile updated successfully!');
                                } else {
                                    showErrorAlert('Error updating profile');
                                }
                            },
                            error: function () {
                                showErrorAlert('Error updating profile');
                            },
                        });
                    },
                    allowOutsideClick: () => !Swal.isLoading(),
                }).then((result) => {
                    if (result.isConfirmed) {
                        showSuccessAlert('Profile updated successfully!');
                    }
                });
            }else {
                // For other fields, use the default text input
                Swal.fire({
                    title: 'Enter New ' + field,
                    input: 'text',
                    inputAttributes: {
                        autocapitalize: 'off',
                    },
                    showCancelButton: true,
                    confirmButtonText: 'Save',
                    showLoaderOnConfirm: true,
                    preConfirm: (value) => {
                        return $.ajax({
                            url: "{{ route('update_profile') }}",
                            method: 'POST',
                            data: {
                                field: field.toLowerCase(),
                                value: value,
                                _token: '{{ csrf_token() }}',
                            },
                            success: function (response) {
                                if (response.success) {
                                    document.querySelector('.profile-data span[data-field="' + field.toLowerCase() + '"]').innerText = value;
                                    showSuccessAlert('Profile updated successfully!');
                                } else {
                                    showErrorAlert('Error updating profile');
                                }
                            },
                            error: function () {
                                showErrorAlert('Error updating profile');
                            },
                        });
                    },
                    allowOutsideClick: () => !Swal.isLoading(),
                }).then((result) => {
                    if (result.isConfirmed) {
                        showSuccessAlert('Profile updated successfully!');
                    }
                });
            }
        }
    }


    function editPassword() {
    promptCurrentPassword();
}

function promptCurrentPassword() {
    Swal.fire({
        title: 'Enter Current Password:',
        input: 'password',
        inputAttributes: {
            autocapitalize: 'off',
        },
        showCancelButton: true,
        confirmButtonText: 'Next',
        showLoaderOnConfirm: true,
        preConfirm: (currentPassword) => {
            return checkCurrentPassword(currentPassword);
        },
    });
}

function checkCurrentPassword(currentPassword) {
    return $.ajax({
        url: "{{ route('check_password') }}",
        method: 'POST',
        data: {
            current_password: currentPassword,
            _token: '{{ csrf_token() }}',
        },
        success: function (response) {
            if (response.success) {
                promptNewPassword();
            } else {
                showErrorAlert('Incorrect current password');
            }
        },
        error: function () {
            showErrorAlert('Error checking password');
        },
    });
}

function promptNewPassword() {
    Swal.fire({
        title: 'Enter New Password:',
        input: 'password',
        inputAttributes: {
            autocapitalize: 'off',
        },
        showCancelButton: true,
        confirmButtonText: 'Next',
        showLoaderOnConfirm: true,
        preConfirm: (newPassword) => {
            // Perform client-side validation
            var validationErrors = validatePasswordFormat(newPassword);

            if (validationErrors.length > 0) {
                showErrorAlert(validationErrors.join('<br>'));
                return false; // Prevent the Swal from closing
            }

            // Continue with the Swal
            return promptConfirmPassword(newPassword);
        },
    });
}

function validatePasswordFormat(password) {
    // Client-side password format validation
    var errors = [];

    if (!password || password.length < 8) {
        errors.push('- Password must be at least 8 characters');
        if (errors.length > 0) {
    }
    }

    if (!/[a-z]/.test(password)) {
        errors.push('- Password must contain at least one lowercase letter');
    }

    if (!/[A-Z]/.test(password)) {
        errors.push('- Password must contain at least one uppercase letter');
    }

    if (!/\d/.test(password)) {
        errors.push('- Password must contain at least one digit');
    }

    if (!/[@$!%*?&.]/.test(password)) {
        errors.push('- Password must contain at least one special character (@$!%*?&.)');
    }

    return errors;
}


function promptConfirmPassword(newPassword) {
    Swal.fire({
        title: 'Confirm your new password:',
        input: 'password',
        inputAttributes: {
            autocapitalize: 'off',
        },
        showCancelButton: true,
        confirmButtonText: 'Save',
        showLoaderOnConfirm: true,
        preConfirm: (confirmPassword) => {
            if (confirmPassword === newPassword) {
                return updatePassword(newPassword);
            } else {
                showErrorAlert('New password and confirm password do not match');
            }
        },
    });
}

function updatePassword(newPassword) {
    return $.ajax({
        url: "{{ route('update_password') }}",
        method: 'POST',
        data: {
            new_password: newPassword,
            _token: '{{ csrf_token() }}',
        },
        success: function (response) {
            if (response.success) {
                showSuccessAlert(response.message);
            } else {
                showErrorAlert('Error updating password');
            }
        },
        error: function () {
            showErrorAlert('Error updating password');
        },
    });
}
    function confirmLogout() {
        Swal.fire({
            title: 'Are you sure?',
            text: 'You will be logged out!',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, log me out!',
            cancelButtonText: 'No, cancel!',
            reverseButtons: true,
        }).then((result) => {
            if (result.isConfirmed) {
                logout();
            }
        });
    }

    function logout() {
        $.ajax({
            url: "{{ route('logout') }}",
            method: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
            },
            success: function (response) {
                window.location.href = "{{ route('login') }}";
            },
            error: function () {
                showErrorAlert('Error logging out');
            },
        });
    }

    function showSuccessAlert(message) {
        Swal.fire({
            icon: 'success',
            title: 'Success!',
            text: message,
        });
    }

    function showErrorAlert(message) {
    Swal.fire({
        icon: 'error',
        title: 'Error!',
        html: message, // Use the html option to render HTML content
    });
}
</script>
{{-- <script>
    function editProfile(field) {
        var newValue;

        if (field == 'profile_picture') {
            // If updating the profile picture, trigger the file input dialog
            var input = document.createElement('input');
            input.type = 'file';
            input.accept = 'image/*';

            // Listen for the change event on the file input
            input.addEventListener('change', function () {
                // Handle the selected file
                var file = input.files[0];
                if (file) {
                    // Make an AJAX request to upload the profile picture
                    var formData = new FormData();
                    formData.append('profile_picture', file);
                    formData.append('_token', '{{ csrf_token() }}');

                    $.ajax({
                        url: "{{ route('upload_profile_picture') }}",
                        method: 'POST',
                        data: formData,
                        contentType: false,
                        processData: false,
                        success: function (response) {
                        if (response.success) {
                            // Update the profile picture src attribute with a timestamp
                            document.querySelector('.profile-data_top img[data-field="profile_picture"]').src = response.url+ '?timestamp=' + new Date().getTime();;
                            // Display the success message
                            alert('Profile picture uploaded successfully!');
                        } else {
                            alert('Error uploading profile picture');
                        }
                    },
                    });
                }
            });

            // Trigger the file input dialog
            input.click();
        } else {
            // If updating other fields, allow the user to input the new value
            newValue = prompt('Enter new ' + field + ':');

            if (newValue !== null) {
                // Make an AJAX request to update the profile
                $.ajax({
                    url: "{{ route('update_profile') }}",
                    method: 'POST',
                    data: {
                        field: field,
                        value: newValue,
                        _token: '{{ csrf_token() }}',
                    },
                    success: function (response) {
                        if (response.success) {
                            // Update the specific field using the data-field attribute
                            document.querySelector('.profile-data span[data-field="' + field + '"]').innerText = newValue;

                            // Add a timestamp to the profile picture URL
                            //document.querySelector('.profile-data_top img[data-field="profile_picture"]').src = '{{ $student->profile_picture }}' + '?timestamp=' + new Date().getTime();

                            // Display the success message
                            alert('Profile updated successfully!');
                        } else {
                            alert('Error updating profile');
                        }
                    },
                    error: function () {
                        alert('Error updating profile');
                    }
                });
            }
        }
    }

    function editPassword() {
    var currentPassword = prompt('Enter your current password:');

    if (currentPassword !== null) {
        // Make an AJAX request to check the current password
        $.ajax({
            url: "{{ route('check_password') }}",
            method: 'POST',
            data: {
                current_password: currentPassword,
                _token: '{{ csrf_token() }}',
            },
            success: function (response) {
                if (response.success) {
                    // Password is correct, prompt for new password
                    var newPassword = prompt('Enter your new password:');

                    if (newPassword !== null) {
                        var confirmPassword = prompt('Confirm your new password:');

                        if (confirmPassword !== null) {
                            // Check if new password and confirm password match
                            if (newPassword === confirmPassword) {
                                // Make an AJAX request to update the password
                                $.ajax({
                                    url: "{{ route('update_password') }}",
                                    method: 'POST',
                                    data: {
                                        new_password: newPassword,
                                        _token: '{{ csrf_token() }}',
                                    },
                                    success: function (response) {
                                        alert(response.message);
                                    },
                                    error: function () {
                                        alert('Error updating password');
                                    },
                                });
                            } else {
                                alert('New password and confirm password do not match');
                            }
                        }
                    }
                } else {
                    alert('Incorrect current password');
                }
            },
            error: function () {
                alert('Error checking password');
            },
        });
    }
}

function confirmLogout() {
        if (confirm("Are you sure you want to log out?")) {
            logout();
        }
    }

function logout() {
        // Make an AJAX request to logout
        $.ajax({
            url: "{{ route('logout') }}",
            method: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
            },
            success: function (response) {
                // Handle the logout success, e.g., redirect to the login page
                window.location.href = "{{ route('login') }}"; // You can change 'login' to your desired route
            },
            error: function () {
                alert('Error logging out');
            },
        });
    }


</script> --}}





@endsection
