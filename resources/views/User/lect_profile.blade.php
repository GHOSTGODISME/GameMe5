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
<div class="profile-data">
    <label class="profile-label">Email</label>
    <div class= "profile_output_email">
        <span data-field="email">{{ $lecturer->user->email }}</span>
    </div>
</div>

<div class="profile-data" onclick="editProfile('name')">
    <label class="profile-label">Name</label>
    <div class= "profile_output">
        <span data-field="name">{{ $lecturer->user->name }}</span>
        <button class="edit-button"></button>
    </div>
</div>


    <div class="profile-data" onclick="editProfile('gender')">
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

<script>
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
                                document.querySelector('.profile-data_top img[data-field="profile_picture"]').src = response.url + '?timestamp=' + new Date().getTime();
                                // Display the success message
                                alert('Profile picture uploaded successfully!');
                            } else {
                                alert('Error uploading profile picture');
                            }
                        },
                        error: function () {
                            alert('Error uploading profile picture');
                        }
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
            var url = "{{ route('update_profile') }}";
            $.ajax({
                url: url,
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
                        //document.querySelector('.profile-data img[data-field="profile_picture"]').src = '{{ $lecturer->user->profile_picture }}' + '?timestamp=' + new Date().getTime();
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
function updateLecturerPosition(newPosition) {
    var newValue = prompt('Enter ' + newPosition + ':');
    if (newValue !== null) {
    $.ajax({
        url: "{{ route('update_lecturer_position') }}",
        method: 'POST',
        data: {
            new_position: newValue,
            _token: '{{ csrf_token() }}',
        },
        success: function (response) {
            if (response.success) {
                // Update the specific field using the data-field attribute
                //document.querySelector('span[data-field=position"]').innerText = newValue;
                // Display the success message
                var positionElement = document.querySelector('[data-field="position"]');
                positionElement.innerText = newValue;
                alert('Profile updated successfully!');
            } else {
                alert('Error updating profile: ' + response.message);
            }
        },
        error: function () {
            alert('Error updating profile');
        }
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


</script>





@endsection
