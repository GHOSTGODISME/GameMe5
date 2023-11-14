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
<h1>Update Student</h1>
</div>
<form action="{{ route('admin_update_student', ['student' => $student->id]) }}" method="POST">
    @csrf
    @method('POST') <!-- Add this line to override the HTTP method -->

    <!-- Add input fields for editing student details -->
    <label id="name" name="name">Name:</label>
    <input type="text" name="name" value="{{ $student->name }}" required>

    <label id="email" name="email">Email:</label>
    <input type="email" name="email" value="{{ $student->email }}" required>

   <!-- Ask for a new password -->
   <label for="new_password">New Password:</label>
   <input type="password" name="new_password">

    <label id="dob" name="dob">Date of Birth:</label>
    <input type="date" name="dob" value="{{ $student->dob }}" required>

    <label id="gender" name="gender">Gender:</label>
    <select name="gender" id="gender">
        <option value="male" {{ $student->gender == 'male' ? 'selected' : '' }}>Male</option>
        <option value="female" {{ $student->gender == 'female' ? 'selected' : '' }}>Female</option>
        <!-- Add more options if needed -->
    </select>
    
    <!-- Add other fields as needed -->

    <button type="submit">Update Student</button>
    <a href="{{ route('admin_stud') }}" class="cancel-button">Cancel</a>
</form>



@endsection