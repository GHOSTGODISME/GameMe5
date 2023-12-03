@extends('Layout/fp_master')

@section('title', 'Forget Password')

@section('content')
<style>
</style>
<style>
</style>
<h1 class="header">Change Password</h1>
<form action="{{ route('forgetpassword_3_post') }}" method="POST">
    @csrf
    <div class="input_label">
        <div class="input_label_small">
            <label for="new_pass">New Password</label>
        </div>
    </div>
    <input type="password" id="txt_new_password" name="new_password" required>

    <div class="input_label">
        <div class="input_label_small">
            <label for="confirm_pass">Confirm New Password</label>
        </div>
    </div>
    <input type="password" id="txt_confirm_new_password" name="confirm_new_password" required><br>

    <button type="submit" class="button_general">Reset Password</button><br>
</form>
@endsection
