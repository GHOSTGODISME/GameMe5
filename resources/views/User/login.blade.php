@extends('Layout/userauth_master')

@section('title', 'Sign In')

@section('content')

<style>
    .forget_pass{
        color: #000;
        font-family: 'Roboto';
        font-size: 12px;
        font-style: normal;
        font-weight: 300;
        line-height: normal;
        text-decoration-line: underline;
    }

    .forget_pass_container{
        width: 300px;
        display: flex;
        justify-content: right;   
        margin-top:10px; 
    }


    #txt_login_email, #txt_login_password {
        padding: 15px;
        border: 1px solid #BFBFBF;
        border-radius: 10px;
        box-sizing: border-box;
        background: #FAFAFA;
        width: 300px;
        height: 34px;
        flex-shrink: 0;
    }
    #txt_login_email{
        margin-bottom: 30px;
    }

    #txt_login_email:focus,#txt_login_password:focus{
        outline: none;
        border-color: #007bff; /* Change the border color on focus */
    } 
    
    #txt_login_email::placeholder, #txt_login_password::placeholder{
        color: #BABABA;
        font-family:'Roboto';
        font-size: 14px;
        font-style:normal;
        font-weight: 400;
        line-height: normal;
    }

    .input_label{
        color: #000;
        font-family: 'Roboto';
        font-size: 16px;
        font-style: normal;
        font-weight: 300;
        line-height: normal;
        margin-bottom:20px;
    }

    .error_message{
        background-color: #f9d0d0;
        padding:10px;
        height:20px;
        display: flex;
        flex-direction: row;
        align-items: center;
        margin-top:5px;
        margin-bottom:20px;
        border-radius:8px;
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
        margin-top:60px;
    }
    .welcome_txt2{
        display:none;
    }
 

    .login-method-selection {
        text-align: center;
        display: flex; /* Use flexbox for the container */
        justify-content: center; /* Center the buttons horizontally */
    }

    .login-method-btn {
        padding: 10px 20px;
        margin-left: 0px; /* Counteract the left padding of the parent */
        margin-right: 50px; /* Adjust as needed */
        cursor: pointer;
        border-top-left-radius: 5px;
        border-top-right-radius: 5px;
        background-color: #6d6d6d;
        font-size: 12px;
        color: #ffffff;

    }

    .login-method-btn.active {
        background: #FAFAFA;
        color: #000000;
        border:1px solid black;
    }

    #manual-login-form {
        display: block; /* Initially show the manual login form */
    }
    #qrcode-con{
        display: none; /* Initially hide the auto QR code display area */
    }

    .qr{
        min-width:300px;
    }

    @media only screen and (max-width: 768px) {
    /* Add specific styles for screens with a maximum width of 600px */
       .welcome_txt1{
          display: none;
        }
        .welcome_txt2{
         display: block;
        }

        #txt_login_email,
        #txt_login_password {
            width: 100%;
        }

        .input_label {
            font-size: 14px;
            margin-bottom: 15px; /* Adjust margin for smaller screens */
        }

        .forget_pass_container {
            width: 100%; /* Make the forget password container full width */
            text-align: center; /* Center the forget password link */
            margin-top: 10px;
        }

        .error_message {
            height: auto; /* Allow error message height to adjust based on content */
        }

        .error_message p {
            font-size: 12px;
        }

        .button_general {
            margin-top: 30px;
            width: 100%; /* Make the button full width */
        }

        .help_txt {
            width: 100%; /* Make the help text full width */
        }
    }
    


</style>
<div class="login-method-selection">
    <div class="login-method-btn active" onclick="showLoginMethod('manual')">Manual Login</div>
    <div class="login-method-btn" onclick="showLoginMethod('qrcode')">QR Code Login</div>
</div>

<h1 class=welcome_txt1>Welcome<br>Back!</h1>
<h1 class=welcome_txt2>Welcome back!</h1>
<div id="manual-login-form">
<form  action="{{route('login_post')}}" method="POST">
    @csrf
    <div class="input_label">
        <label for="login_email">Email:</label>
    </div>
        <input type="email" id="txt_login_email" name="email" placeholder="xxxxx@student.tarc.edu.my" required>
    
    <div class="input_label">
        <label for="login_password">Password:</label>
    </div>
        <input type="password" id="txt_login_password" name="password" placeholder="Enter your password" required><br>
  

    <div class="forget_pass_container"><a class="forget_pass" href="{{route('forgetpassword_1')}}">Forget you password?</a><br></div>
    <div class="error_container">
        @error('email')
           <div class="error_message">
               <img src="{{ asset('img/error_icon.png') }}">
             
              <p> {{ $message }}</p>
           </div>
          @enderror
       </div>
    <button type="submit" class="button_general">Log In</button><br>
    <span class = help_txt >Don't have an account?  <a class="hypertext" href="{{route('signup_1')}}">{{ __('Sign Up')}}</a><span>
</form>
</div>

<!-- QR code display area -->

<div class="qr" id="qrcode-con"></div>

<script>
    // Function to toggle display of manual login form and QR code based on selected login method
    function showLoginMethod(method) {
        var manualLoginForm = document.getElementById("manual-login-form");
        var qrCodeImg = document.getElementById("qrcode-con");

        if (method === "qrcode") {
            manualLoginForm.style.display = "none";
            qrCodeImg.style.display = " block";
            document.querySelector('.login-method-btn.active').classList.remove('active');
            document.querySelector('.login-method-btn:nth-child(2)').classList.add('active');
        } else {
            manualLoginForm.style.display = "block";
            qrCodeImg.style.display = "none";
            document.querySelector('.login-method-btn.active').classList.remove('active');
            document.querySelector('.login-method-btn:nth-child(1)').classList.add('active');
        }
    }

    function generateQRCode() {
        var qrCodeElement = document.getElementById("qrcode-con");
        var data = "https://www.facebook.com/";
        // Create a QR code instance
        var qr = new QRCode(qrCodeElement, {
            text: data,
            width: 128,
            height: 128,
            colorDark: "#000000",
            colorLight: "#ffffff",
            correctLevel: QRCode.CorrectLevel.H
        });
    }

    window.onload = function () {
        generateQRCode();
        showLoginMethod('manual'); // Show manual login initially
    };
</script>

@endsection