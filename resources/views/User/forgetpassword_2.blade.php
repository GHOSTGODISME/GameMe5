@extends('Layout/fp_master')

@section('title', 'Forget Password')

@section('content')
<style>
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

      
    </table>
    <button class=button_general type="submit" class="btn_reset_password">Reset Password</button><br>
</form>


@endsection