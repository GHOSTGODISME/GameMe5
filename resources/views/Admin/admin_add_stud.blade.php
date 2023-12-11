@extends('Layout/admin_master')

@section('title', 'Admin Dashboard')

@section('content')
<style>
    .title_bar{
    display: flex;
    flex-direction: row;
    }
    .add_icon{
        width:30px;
        height:30px;
        align-self: center;
    }

    .stud-page a {
    text-decoration: underline;
    /* Add any other styles for the current page link */
    }
    .error_message{
        background-color: #f9d0d0;
        padding:10px;
        display: flex;
        flex-direction: row;
        align-items: center;
        border-radius:8px;

        }

    .error_message p{
        margin-left:15px;
        font-family: 'Roboto';
        font-size: 12px;
        font-style: normal;
        font-weight: 300;
        line-height: normal;
        color: #D8000C;
    }

    .error_container{
        margin-top:20px;
    }
</style>

<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<div class = "title_bar">
<h1 class= "admin_title">Add Student</h1>
</div>
<form action="{{ route('admin_add_student') }}" method="POST" class="add_student_form" enctype="multipart/form-data">
    @csrf
   <div class=admin_row>
        <div class="studE_info">
            <div class="input_group">
                <p class="label_admin_stud">Student Name:</p>
            </div>
            <div><input type="text" class="admin_input" name="name" required></div>
        </div>

        <div class="studE_info">
            <div class="input_group">
                <p class="label_admin_stud">Student Email:</p>
            </div>
            <div><input type="text" class="admin_input" name="email" required></div>
        </div>
    </div>

            <!-- Add other student information fields as needed -->
            <div class=admin_row>
                    <div class="studE_info">
                        <div class="input_group">
                            <p class="label_admin_stud">Password: </p>
                        </div>
                        <div><input class="admin_input" type="password" name="password" required></div>
                    </div>
           
                    <div class="studE_info">
                        <div class="input_group">
                            <p class="label_admin_stud">Date of Birth:</p>
                        </div>
                        <div class="styled-date-input">
                            <input type="date" class="admin_input" name="dob" required>
                        </div>
                    </div>
            </div>

            <!-- Add other student information fields as needed -->

            <div class="admin_row">
                <div class="studE_info">
                    <div class="input_group">
                        <p class="label_admin_stud">Gender:</p>
                    </div>
                    <div class="styled-select">
                        <select name="gender" class="admin_input" required>
                            <option value="male">Male</option>
                            <option value="female">Female</option>
                            <!-- Add more options if needed -->
                        </select>
                    </div>
                </div>
         
            
       
                    <div class="studE_info">
                        <div class="input_group">
                            <p class="label_admin_stud">Account Type: </p>
                        </div>
                        <div>
                        <div class="styled-select">
                            <select name="accountType" class="admin_input" required>
                                <option value="student">Student</option>
                                <!-- Add more options if needed -->
                            </select>
                        </div>
                        </div>
                    </div>
                </div>
                <div class="admin_row">
                    <div class="input_group"></div>
                    <div class="comp-button-container">
                        <button type="submit" class="confirm-button">Confirm</button>
                        <a class="cancel-button" href="{{ route('admin_stud') }}">Cancel</a>
                    </div>
                </div>
        
         
                @if(session('success'))
                <script>
                    showSuccessPopup("{{ session('success') }}");
                    function showSuccessPopup(successMessage) {
                        Swal.fire({
                            title: 'Success!',
                            text: successMessage,
                            icon: 'success',
                            confirmButtonText: 'OK'
                        });
                    }
                </script>
            @endif

            @php
            $errorMessage = [
                'name' => $errors->first('name'),
                'gender' => $errors->first('gender'),
                'dob' => $errors->first('dob'),
                'password' => $errors->first('password'),
                // Add more fields if needed
            ];
            @endphp
            
            <div class="error_container">
            @foreach($errorMessage as $error)
                @if($error)
                    <div class="error_message">
                        <img src="{{ asset('img/error_icon.png') }}">
                        <p>{!! nl2br($error) !!}</p>
                    </div>
                    @break
                @endif
            @endforeach
            </div>
   



@endsection