@extends('Layout/fp_master')

@section('title', 'Forget Password')

@section('content')
<style>
</style>
<h1>Password Recovery</h1>
<p>If you do not receive the email within a few minutes, please check your junk/spam email folder.</p><br>
<form action="{{ route('forgetpassword_2_post') }}" method="POST">
    @csrf
    <table class="forgetpassword_table">
        <tr class="forgetpassword_row">
            <td>
                <div class="input_group">
                    <label for="txt_forgetpassword_vc">Verification Code</label>
                </div>
            </td>
        </tr>
        <tr class="forgetpassword_row">
            <td>
                <div class="input_group">
                    <input type="text" id="txt_forgetpassword_vc" name="verification_code" required>
                </div>
            </td>
        </tr>
    </table>
    <button type="submit" class="btn_reset_password">Reset Password</button><br>
</form>


@endsection