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
<h1 class="header">Password Recovery</h1>
<p class=fp_desc>If you do not receive the email within a few minutes, please check your junk/spam email folder.</p><br>
<form action="{{ route('forgetpassword_2_post') }}" method="POST">
    @csrf
    <table class="forgetpassword_table">
      
                <div class="input_label">
                    <div class="input_label_small">
                    <label for="forget_code">Verification Code</label>
                    </div>
                </div>
                    <input type="text" id="txt_forgetpassword_vc" name="verification_code" required>
                    <div class="input_label">
                        <div class="input_label_small">
                            @error('verification_code') <!-- Corrected field name here -->
                                <div class="error_message">
                                    <img src="{{ asset('img/error_icon.png') }}">
                                    <p>{{ $message }}</p>
                                </div>
                            @enderror
                        </div>
                    </div>
      
    </table>
    <button class=button_general type="submit" class="btn_reset_password">Continue</button><br>
</form>


@endsection