@extends('Layout/fp_master')

@section('title', 'Forget Password')

@section('content')
<style>
     .error_message{
	background-color: #f9d0d0;
    padding:10px;

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
        text-align: left;
    }

    .button_general{
        margin-top:30px;
    }
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
    <div class="input_label">
        <div class="input_label_small">
           @error('new_password') 
                <div class="error_message">
                    <img src="{{ asset('img/error_icon.png') }}">
                    <p>{!! nl2br($message) !!}</p>
                </div>
       @enderror 
        </div>
    </div>

    <div class="input_label">
        <div class="input_label_small">
            @error('confirm_new_password')
                <div class="error_message">
                    <img src="{{ asset('img/error_icon.png') }}">
                    <p>{{ $message }}</p>
                </div>
            @enderror
        </div>
    </div>
    <button type="submit" class="button_general">Reset Password</button><br>
</form>

@if(session('success'))
    <script>
        // Use your preferred library or custom code for a popup/modal
        alert('Password reset successful. You can now login with your new password.');
        // You can redirect to the login page after the user acknowledges the success
        window.location.href = '{{ route("login") }}';
    </script>
@endif

@endsection
