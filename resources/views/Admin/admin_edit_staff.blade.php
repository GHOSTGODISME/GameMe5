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
<div class = title_bar>
<h1 class= "admin_title">Update Staff</h1>
</div>
<form action="{{ route('admin_update_staff', ['staff' => $staff->id]) }}" method="POST">
    @csrf
    @method('POST') <!-- Add this line to override the HTTP method -->

    <input type="hidden" id="user_id" name="user_id" value={{$user->id}}>
    <!-- Add input fields for editing student details -->
    <div class=admin_row>
        <div class="studE_info">
            <div class="input_group">
                <p  class="label_admin_stud" id="name" name="name">Name:</p>
            </div>
            <div><input type="text" class="admin_input"  name="name" value="{{ $user->name }}" ></div>
        </div>
        <div class="studE_info">
            <div class="input_group">
                <p class="label_admin_stud"  id="email" name="email">Email:</p>
            </div>
            <div><input type="email" class="admin_input" name="email" value="{{ $user->email }}" ></div>
        </div>
    </div>

   <!-- Ask for a new password -->
   <div class=admin_row>
    <div class="studE_info">
        <div class="input_group">
            <p class="label_admin_stud" for="new_password">New Password:</p>
        </div>
        <div><input class="admin_input" type="password" name="new_password"></div>
    </div>
        <div class="studE_info">
            <div class="input_group">
                <p class="label_admin_stud" id="dob" name="dob">Date of Birth:</p>
            </div>
            <div class="styled-date-input">
                <input class="admin_input" type="date" name="dob" value="{{ $user->dob }}" >
            </div>
        </div>
    </div>

    <div class=admin_row>
        <div class="studE_info">
            <div class="input_group">
                <p class="label_admin_stud" id="gender" name="gender">Gender:</p>
            </div>
        
        <div class="styled-select">
        <select name="gender" id="gender" class="admin_input">
        <option value="male" {{ $user->gender == 'male' ? 'selected' : '' }}>Male</option>
        <option value="female" {{ $user->gender == 'female' ? 'selected' : '' }}>Female</option>
        <!-- Add more options if needed -->
    </select>
</div>
</div>
    <div class="studE_info">
    <div class="input_group">
        <p class="label_admin_stud" id="position" name="position">Position:</p>
    </div>
    <div><input type="text" class="admin_input" name="position" value="{{ $staff->position }}" required></div>
        <!-- Add other fields as needed -->
    </div>
</div>
<div class="admin_row">
    <div class="input_group"></div>
    <div class="comp-button-container">
    <button type="submit"  class="confirm-button" >Update Staff</button>
    <a href="{{ route('admin_staff') }}" class="cancel-button">Cancel</a>
</div>
</div>
</form>



@endsection