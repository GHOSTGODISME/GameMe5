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

    .staff-page a {
    text-decoration: underline;
    /* Add any other styles for the current page link */
    }

</style>
<div class = "title_bar">
<h1 class= "admin_title">Add Staff</h1>
</div>
<form action="{{ route('admin_add_staff') }}" method="POST" class="add_staff_form" enctype="multipart/form-data">
    @csrf

    <div class=admin_row>
             
                    <div class="studE_info">
                        <div class="input_group">
                            <p class="label_admin_stud">Staff Name:</p>
                        </div>
                        <div><input type="text" class="admin_input" name="name"></div>
                    </div>
      
           
                    <div class="studE_info">
                        <div class="input_group">
                            <p class="label_admin_stud">Staff Email:</p>
                        </div>
                        <div><input type="text" class="admin_input" name="email"></div>
                    </div>
                </div>

            <!-- Add other student information fields as needed -->

            <div class=admin_row>
                    <div class="studE_info">
                        <div class="input_group">
                            <p class="label_admin_stud">Password: </p>
                        </div>
                        <div><input class="admin_input" type="password" name="password"></div>
                    </div>
           

          
                         
                    <div class="studE_info">
                        <div class="input_group">
                            <p class="label_admin_stud">Date of Birth:</p>
                        </div>
                        <div class="styled-date-input">
                            <input type="date" class="admin_input" name="dob">
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
                        <select name="gender" class="admin_input">
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
                        <select name="accountType" class="admin_input">
                            <option value="student">Student</option>
                            <!-- Add more options if needed -->
                        </select>
                    </div>
                    </div>
                </div>
                </div>

                <div class="admin_row">
                    <div class="studE_info">
                        <div class="input_group">
                            <p class="label_admin_stud">Position: </p>
                        </div>
                        <div><input type="text" class="admin_input" name="position"></div>
                    </div>
                </div>
   
    <!-- Include the rest of your form for adding a student -->
    <div class="admin_row">
        <div class="input_group"></div>
        <div class="comp-button-container">
            <button type="submit" class="confirm-button">Confirm</button>
            <a class="cancel-button" href="{{ route('admin_staff') }}">Cancel</a>
        </div>
    </div>

    @if (session('success_message'))
        <div class="success_message">{{ session('success_message') }}</div>
    @endif
</form>



@endsection