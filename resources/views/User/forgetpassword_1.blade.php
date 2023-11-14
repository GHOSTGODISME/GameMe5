@extends('Layout/fp_master')

@section('title', 'Forget Password')

@section('content')
<style>
</style>
<h1>Forgot Your Password?</h1>
<p>We'll email you a verification code to reset the password</p><br>
<form action="{{ route('forgetpassword_1_post') }}" method="POST">
    @csrf
    <table class="forgetpassword_table">
        <tr class="forgetpassword_row">
            <td>
                <div class="input_group">
                    <label for="txt_forgetpassword_email">Email:</label>
                </div>
            </td>
        </tr>
        <tr class="forgetpassword_row">
            <td>
                <div class="input_group">
                    <input type="email" id="txt_forgetpassword_email" name="email" placeholder="xxxxx@student.tarc.edu.my" required>
                </div>
            </td>
        </tr>
    </table>
    <button type="submit" class="btn_get_verification_code">Get Verification Code</button><br>
    <span>Back to Log In <a href="{{ route('login') }}">{{ __('Login') }}</a></span>
</form>


@endsection