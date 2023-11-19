@extends('Layout/fp_master')

@section('title', 'Forget Password')

@section('content')
<style>
</style>
<h1 class="header">Forgot Your Password?</h1>
<p class=fp_desc>We'll email you a verification code to reset the password</p><br>
<form action="{{ route('forgetpassword_1_post') }}" method="POST">
    @csrf

                <div class="input_label">
                    <div class="input_label_small">
                    <label for="forget_email">Email</label>
                    </div>
                </div>
                <input type="email" id="txt_forgetpassword_email" name="email" placeholder="xxxxx@student.tarc.edu.my" required><br>
           
 
    <button type="submit" class="button_general">Get Verification Code</button><br>
    <span class="help_txt"><a href="{{ route('login') }}">{{ __('Back to Login') }}</a></span>
</form>


@endsection