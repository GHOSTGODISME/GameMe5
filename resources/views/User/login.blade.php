@extends('Layout/userauth_master')

@section('title', 'Sign In')

@section('content')
<style>
</style>
<h1>Welcome<br>Back!</h1>
<form action="{{route('login_post')}}" method="POST">
    @csrf
    <table class="login_table">
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
    <a href="{{route('forgetpassword_1')}}">Forget you password?</a><br>
    <button type="submit" class="btn_login_sign_in">Log In</button><br>
    <span>Don't have an account?<a href="{{route('admin_staff')}}">{{ __('admin_staff')}}</a><span>
</form>
@endsection