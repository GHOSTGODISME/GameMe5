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
    margin-bottom:50px;
}

.blank{
    height:250px;
}


#txt_signup_email {
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

    #txt_signup_email :focus{
        outline: none;
        border-color: #007bff; /* Change the border color on focus */
    } 
    
    #txt_signup_email::placeholder{
        color: #BABABA;
        font-family:'Roboto';
        font-size: 14px;
        font-style:normal;
        font-weight: 400;
        line-height: normal;
    }
     .error_message{
	background-color: #f9d0d0;
    padding:10px;
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
    .error_container{
        height:50px;
        margin-bottom:15px;
    }
 
</style>
<h1>Sign Up</h1>
<img class= progress_bar src="img/progress_bar1.png" alt= "progress_bar"/>
<form method="post" action="{{ route('signup_2') }}">
    @csrf
    <!-- Add fields for the second step, e.g., email -->
    <div class="input_label_signup">
    <label for="txt_login_email">Enter Your Institution Email Address</label>
    </div>
    <input type="email" name="email" id="txt_signup_email" placeholder="xxxxx@student.tarc.edu.my"  required>
    <div class="error_container">
        @error('email')
           <div class="error_message">
               <img src="{{ asset('img/error_icon.png') }}">
              <p> {{ $message }}</p>
           </div>
          @enderror
       </div>
    <div class=blank></div>
    <!-- Add other fields as needed -->
    <button class=button_general type="submit">Continue</button>
</form>
<span class = help_txt >Already have an account?<a href="{{route('login')}}">{{ __('Login')}}</a><span>
@endsection