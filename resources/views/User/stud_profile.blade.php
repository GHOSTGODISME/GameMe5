@extends('Layout/student_master')

@section('title', 'Profile')

@section('content')
<style>
.profile_picture{
width:300px;
height:300px;

}
</style>
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<h1>Profile</h1>
<u><p>Edit Profile</p></u>
<div class="profile-container">
    <div class="profile-data">
        <label class="profile-label">Profile Picture:</label>
        <!-- Display profile picture -->
        <img class= profile_picture src="{{ $student->profile_picture ? url($student->profile_picture) : asset('path_to_default_image') }}" alt="Profile Picture" data-field="profile_picture">
        <button class="edit-button" onclick="editProfile('profile_picture')">Edit</button>
    </div>
    

    
   <!-- Add an identifier (e.g., data-field="email") to each profile data span -->
<div class="profile-data">
    <label class="profile-label">Email:</label>
    <span data-field="email">{{ $student->email }}</span>
</div>


    <div class="profile-data">
        <label class="profile-label">Name:</label>
        <span data-field="name">{{ $student->name }}</span>
        <button class="edit-button" onclick="editProfile('name')">Edit</button>
    </div>


    <div class="profile-data">
        <label class="profile-label">Gender:</label>
        <span data-field="gender">{{ $student->gender }}</span>
        <button class="edit-button" onclick="editProfile('gender')">Edit</button>
    </div>

    <div class="profile-data">
        <label class="profile-label">Date of Birth:</label>
        <span data-field="dob">{{ $student->dob }}</span>
        <button class="edit-button" onclick="editProfile('dob')">Edit</button>
    </div>

    <div class="profile-data">
        <label class="profile-label">Password:</label>
        <span data-field="password">Change New Password</span>
        <button class="edit-button" onclick="editPassword()">Edit</button>
    </div>
    
    <div class="profile-data">
        <button class="logout-button" onclick="logout()">Logout</button>
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
                                document.querySelector('.profile-data img[data-field="profile_picture"]').src = response.url + '?timestamp=' + new Date().getTime();
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
                            document.querySelector('.profile-data img[data-field="profile_picture"]').src = '{{ $student->profile_picture }}' + '?timestamp=' + new Date().getTime();

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