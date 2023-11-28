@extends('Layout/userauth_master')

@section('title', 'Sign Up')

@section('content')
<style>
.input_label_signup{
color: #000;
font-family: 'Roboto';
font-size: 16px;
font-style: normal;
font-weight: 300;
line-height: normal;
margin-bottom:20px;
}

.progress_bar{
    width:300px;
    height:30px;
    margin-bottom: 50px;
}
#txt_signup_name, #txt_signup_password,#txt_signup_dob {
        padding: 15px;
        border: 1px solid #BFBFBF;
        border-radius: 10px;
        box-sizing: border-box;
        background: #FAFAFA;
        width: 300px;
        height: 34px;
        flex-shrink: 0;
        margin-bottom:30px;
    }

    #txt_signup_gender{
        padding: 10px;
        border: 1px solid #BFBFBF;
        border-radius: 10px;
        box-sizing: border-box;
        background: #FAFAFA;
        width: 300px;
        height: 36px;
        flex-shrink: 0;
        margin-bottom:30px;
    }

    #txt_signup_name:focus,#txt_signup_password:focus,#txt_signup_gender:focus,#txt_signup_dob:focus{
        outline: none;
        border-color: #007bff; /* Change the border color on focus */
    } 
    
    #txt_signup_name::placeholder, #txt_signup_password::placeholder,#txt_signup_gender::placeholder,#txt_signup_dob::placeholder{
        color: #BABABA;
        font-family:'Roboto';
        font-size: 14px;
        font-style:normal;
        font-weight: 400;
        line-height: normal;
    }
    .blank{
     height:10px;   
    }

    .password-container {
        position: relative;
    }

    .eye-icon {
    position: absolute;
    right: 15px;
    top: 30%;
    transform: translateY(-50%);
    cursor: pointer;
    width: 15px; /* Adjust the width as needed */
    height: 10px; /* Adjust the height as needed */
}
   


</style>
<h1>Sign Up</h1>
<img class= progress_bar src="img/progress_bar2.png" alt= "progress_bar"/>
<form action="{{ route('signup_post') }}" method="POST">
    @csrf
    <div class="input_label_signup">
        <label for="signup_name">Name</label>
    </div>
        <input type="text" id="txt_signup_name" name="name" placeholder="Enter your full name" required>

    <div class="input_label_signup">
        <label for="signup_gender">Gender</label>
    </div>
        <select id="txt_signup_gender" name="gender" required>
            <option class="select_val" value="male">Male</option>
            <option class="select_val" value="female">Female</option>        
        </select>

    <div class="input_label_signup">
        <label for="signup_dob">Date of Birth</label>
    </div>
        <input type="date" id="txt_signup_dob" name="dob" required>

        <div class="input_label_signup">
            <label for="signup_password">Password</label>
        </div>
        <div class="password-container">
            <input type="password" id="txt_signup_password" name="password" placeholder="Enter your password" required>
            <img class="eye-icon" id="togglePassword" src="img/eye_icon.png" alt="Toggle Password Visibility">
        </div>
        

    <div class=blank></div>

    <button type="submit" class="button_general">Sign Up</button>
</form>
<span class = help_txt >Already have an account?<a href="{{route('login')}}">{{ __('Login')}}</a><span>
<script>
    document.getElementById('togglePassword').addEventListener('click', function() {
        var passwordInput = document.getElementById('txt_signup_password');
        var type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
        passwordInput.setAttribute('type', type);
    });
</script>
    
@endsection