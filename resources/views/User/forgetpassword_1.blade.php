@extends('Layout/fp_master')

@section('title', 'Forget Password')

@section('content')
<style>
    .error_message{
	background-color: #f9d0d0;
    padding:10px;
    height:20px;
    display: flex;
    flex-direction: row;
    align-items: center;
    margin-top:5px;
    border-radius:8px;
    width: 300px;
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

    .button_general{
        margin-top:30px;
    }
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
                <div class="input_label">
                    <div class="input_label_small">
                @error('email')
                  <div class="error_message">
                    <img src="{{ asset('img/error_icon.png') }}">
                    <p>{{ $message }}</p>
                 </div>
                @enderror    
            </div>
        </div>
              
 
    <button type="submit" class="button_general">Get Verification Code</button><br>
    <span class="help_txt"><a href="{{ route('login') }}">{{ __('Back to Login') }}</a></span>
</form>


@endsection