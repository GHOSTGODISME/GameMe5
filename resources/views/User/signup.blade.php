@extends('Layout/userauth_master')

@section('title', 'Sign Up')

@section('content')
<style></style>
<h1>Sign<br>Up!</h1>
<form action="{{route('signup_post')}}" method="POST">
    @csrf
    <table class="login_table">
        <tr class="login_row">
            <td>
                <div class="input_group">
                    <label for="txt_login_email">Name:</label>
                </div>
            </td>
        </tr>
        <tr class="login_row">
            <td>
                <div class="input_group">
                    <input type="name" id="txt_login_name" name="name" placeholder="Vickham Foo" required>
                </div>
            </td>
        </tr>

        <tr class="login_row">
            <td>
                <div class="input_group">
                    <label for="txt_login_email">Email:</label>
                </div>
            </td>
        </tr>
        <tr class="login_row">
            <td>
                <div class="input_group">
                    <input type="email" id="txt_login_email" name="email" placeholder="xxxxx@student.tarc.edu.my" required>
                </div>
            </td>
        </tr>
        <tr class="login_row">
            <td>
                <div class="input_group">
                    <label for="txt_login_password">Password:</label>
                </div>
            </td>
        </tr>
        <tr class="login_row">
            <td>
                <div class="input_group">
                    <input type="password" id="txt_login_password" name="password" placeholder="Enter your password" required>
                </div>
            </td>
        </tr>
    </table>
    <a href="forgotpassword">Forgot Password</a><br>
    <button type="submit" class="btn_login_sign_in">Sign Up</button><br>
    <span>Already have an account?<a href="{{route('login')}}">{{ __('Login')}}</a><span>
</form>
@endsection