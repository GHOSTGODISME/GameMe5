@extends('Layout/userauth_master')

@section('title', 'Sign Up')

@section('content')
<style></style>
<h1>Sign<br>Up!</h1><form action="{{ route('signup_post') }}" method="POST">
    @csrf
    <table class="signup_table">
        <tr class="signup_row">
            <td>
                <div class="signup_input_group">
                    <label for="signup_name">Name:</label>
                </div>
            </td>
        </tr>
        <tr class="signup_row">
            <td>
                <div class="signup_input_group">
                    <input type="text" id="signup_name" name="name" placeholder="Enter your full name" required>
                </div>
            </td>
        </tr>

        <tr class="signup_row">
            <td>
                <div class="signup_input_group">
                    <label for="signup_gender">Gender:</label>
                </div>
            </td>
        </tr>
        <tr class="signup_row">
            <td>
                <div class="signup_input_group">
                    <select id="signup_gender" name="gender" required>
                        <option value="male">Male</option>
                        <option value="female">Female</option>
                        <!-- Add other gender options as needed -->
                    </select>
                </div>
            </td>
        </tr>

        <tr class="signup_row">
            <td>
                <div class="signup_input_group">
                    <label for="signup_dob">Date of Birth:</label>
                </div>
            </td>
        </tr>
        <tr class="signup_row">
            <td>
                <div class="signup_input_group">
                    <input type="date" id="signup_dob" name="dob" required>
                </div>
            </td>
        </tr>        

        <tr class="signup_row">
            <td>
                <div class="signup_input_group">
                    <label for="signup_password">Password:</label>
                </div>
            </td>
        </tr>
        <tr class="signup_row">
            <td>
                <div class="signup_input_group">
                    <input type="password" id="signup_password" name="password" placeholder="Enter your password" required>
                </div>
            </td>
        </tr>
        <!-- Add other fields as needed -->

    </table>
    <button type="submit">Sign Up</button>
</form>

@endsection