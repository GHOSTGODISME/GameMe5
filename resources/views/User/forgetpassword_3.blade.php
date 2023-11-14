@extends('Layout/fp_master')

@section('title', 'Forget Password')

@section('content')
<style>
</style>
<h1>Change Password</h1>
<form action="{{ route('forgetpassword_3_post') }}" method="POST">
    @csrf
    <table class="forgetpassword_table">
        <tr class="forgetpassword_row">
            <td>
                <div class="input_group">
                    <label for="txt_new_password">New Password</label>
                </div>
            </td>
        </tr>
        <tr class="forgetpassword_row">
            <td>
                <div class="input_group">
                    <input type="text" id="txt_new_password" name="new_password" required>
                </div>
            </td>
        </tr>

        <tr class="forgetpassword_row">
            <td>
                <div class="input_group">
                    <label for="txt_confirm_new_password">Confirm New Password</label>
                </div>
            </td>
        </tr>
        <tr class="forgetpassword_row">
            <td>
                <div class="input_group">
                    <input type="text" id="txt_confirm_new_password" name="confirm_new_password" required>
                </div>
            </td>
        </tr>
    </table>
    <button type="submit" class="btn_reset_password">Reset Password</button><br>
</form>


@endsection