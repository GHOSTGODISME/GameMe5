@extends('Layout/lect_master')

@section('title', 'Profile')

@section('content')
<style>
.profile_picture{
width:70px;
height:70px;
border-radius: 50%;
border:2px white solid;
}


.profile_output span {
    text-transform: capitalize; /* Capitalize the text */
}

h1{
    margin-bottom:20px;
}

.profile_output{
    align-items: center;
}

.profile_output p{
    margin:0;
}


</style>
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<h1 class="lect_title">Profile</h1>
<u><p class="lect_subtitle">Edit Profile</p></u>
<div class="profile-big-container">
<div class="profile-container">
    <div class="profile-data_top"  onclick="editProfile('profile_picture')">
        <div class="profile-label">
        <!-- Display profile picture -->
        <img class= profile_picture src="{{ $lecturer->user->profile_picture ? url($lecturer->user->profile_picture) : asset('path_to_default_image') }}" alt="Profile Picture" data-field="profile_picture">
        </div>
        <div class= "profile_output">
            <p class=profile_txt>Change Profile Picture</p>
            <button class="edit-button"></button>
        </div>
    </div>
    
   <!-- Add an identifier (e.g., data-field="email") to each profile data span -->
<div class="profile-data" style="cursor:default;">
    <label class="profile-label">Email</label>
    <div class= "profile_output_email">
        <span data-field="email">{{ $lecturer->user->email }}</span>
    </div>
</div>

<div class="profile-data" onclick="editProfile('Name')">
    <label class="profile-label">Name</label>
    <div class= "profile_output">
        <span data-field="name">{{ $lecturer->user->name }}</span>
        <button class="edit-button"></button>
    </div>
</div>


    <div class="profile-data" onclick="editProfile('Gender')">
        <label class="profile-label">Gender</label>
        <div class= "profile_output">
            <span data-field="gender">{{ $lecturer->user->gender }}</span>
            <button class="edit-button"></button>
        </div>
    </div>

    <div class="profile-data" onclick="editProfile('dob')">
        <label class="profile-label">Date of Birth</label>
        <div class= "profile_output">
            <span data-field="dob">{{ $lecturer->user->dob }}</span>
            <button class="edit-button"></button>
        </div>
    </div>

    <div class="profile-data" onclick="editPassword()">
        <label class="profile-label">Password</label>
        <div class= "profile_output">
            <span data-field="password">Change New Password</span>
            <button class="edit-button"></button>
        </div>
    </div>
    
    <div class="profile-data_low" onclick="updateLecturerPosition('new position')">
        <label class="profile-label">Position</label>
        <div class= "profile_output">
            <span data-field="position">{{ $lecturer->position }}</span>
            <button class="edit-button"></button>
        </div>
    </div>

</div>
    <div class="profile-data_logout" onclick="confirmLogout()">
        <label class="profile-label_logout">Log Out</label>
        <button class="logout-button"></button>
    </div>

    <!-- Add more fields as needed -->

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
            var promptTitle = 'Enter New ' + field;
            var promptInputType = 'text';

            if (field.toLowerCase() === 'gender') {
                // For the gender field, show a dropdown
                promptTitle = 'Select Gender';
                promptInputType = 'select';
            } else if (field.toLowerCase() === 'dob') {
                // For the dob field, show a date picker
                promptTitle = 'Select Date of Birth';
                promptInputType = 'date';
            }

            Swal.fire({
                title: promptTitle,
                input: promptInputType,
                inputValue: field.toLowerCase() === 'dob' ? '{{ $lecturer->user->dob }}' : null,
                inputOptions: field.toLowerCase() === 'gender' ? { 'male': 'Male', 'female': 'Female' } : null,
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
    function updateLecturerPosition(newPosition) {
    Swal.fire({
        title: 'Enter ' + newPosition + ':',
        input: 'text',
        inputAttributes: {
            autocapitalize: 'off',
        },
        showCancelButton: true,
        confirmButtonText: 'Save',
        showLoaderOnConfirm: true,
        preConfirm: (newValue) => {
            return $.ajax({
                url: "{{ route('update_lecturer_position') }}",
                method: 'POST',
                data: {
                    new_position: newValue,
                    _token: '{{ csrf_token() }}',
                },
                success: function (response) {
                    if (response.success) {
                        // Update the specific field using the data-field attribute
                        var positionElement = document.querySelector('[data-field="position"]');
                        positionElement.innerText = newValue;
                        showSuccessAlert('Profile updated successfully!');
                    } else {
                        showErrorAlert('Error updating profile: ' + response.message);
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

    </script>





@endsection
