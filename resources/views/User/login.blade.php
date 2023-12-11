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
 


</style>
<h1 class=header>Welcome<br>Back!</h1>

<form action="{{route('login_post')}}" method="POST">
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

@endsection