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
</style>
<div class = title_bar>
<h1>Add Student</h1>
</div>
<form action="{{ route('admin_add_student') }}" method="POST" class="add_student_form" enctype="multipart/form-data">
    @csrf
    <table>
        <tbody>
            <tr class="studE_row">
                <td class="compD_Col">
                    <div class="studE_info">
                        <div class="input_group">
                            <p class="header_stud_email">Student Name:</p>
                        </div>
                        <div><input type="text" class="comp_input" name="name"></div>
                    </div>
                </td>
                <td class="compD_Col">
                    <div class="studE_info">
                        <div class="input_group">
                            <p class="header_stud_email">Student Email:</p>
                        </div>
                        <div><input type="text" class="comp_input" name="email"></div>
                    </div>
                </td>
            </tr>

            <!-- Add other student information fields as needed -->

            <tr class="studE_row">
                
                <td class="compD_Col">
                    <div class="studE_info">
                        <div class="input_group">
                            <p class="header_stud_phone">Password: </p>
                        </div>
                        <div><input class="comp_input" type="password" name="password"></div>
                    </div>
                </td>
                <td class="compD_Col">
                    <div class="studE_info">
                        <div class="input_group">
                            <p class="header_stud_phone">Date of Birth: </p>
                        </div>
                        <div><input type="date" class="comp_input" name="dob"></div>
                    </div>
                </td>
            </tr>

            <!-- Add other student information fields as needed -->

            <tr class="studE_row">
                <td class="compD_Col">
                    <div class="studE_info">
                        <div class="input_group">
                            <p class="header_stud_email">Gender: </p>
                        </div>
                        <div>
                            <select name="gender" class="comp_input">
                                <option value="male">Male</option>
                                <option value="female">Female</option>
                                <!-- Add more options if needed -->
                            </select>
                        </div>
                    </div>
                </td>
                <td class="compD_Col">
                    <div class="studE_info">
                        <div class="input_group">
                            <p class="header_stud_phone">Account Type: </p>
                        </div>
                        <div>
                            <select name="accountType" class="comp_input">
                                <option value="student">Student</option>
                                <!-- Add more options if needed -->
                            </select>
                        </div>
                    </div>
                </td>
            </tr>
        </tbody>
    </table>

    <!-- Include the rest of your form for adding a student -->

    <div class="stud_infoo">
        <div class="comp-button-container">
            <button type="submit" class="confirm-button">Confirm</button>
            <a class="cancel-button" href="{{ route('admin_stud') }}">Cancel</a>
        </div>
    </div>

    @if (session('success_message'))
        <div class="success_message">{{ session('success_message') }}</div>
    @endif
</form>



@endsection