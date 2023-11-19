@extends('Layout/userauth_master')

@section('title', 'Sign Up')

@section('content')
<style>

.signup_title{
    color: #000;
    font-family: 'Roboto';
    font-size: 23px;
    font-style: normal;
    font-weight: 500;
    line-height: normal;
    margin-bottom:50px;
    margin-top:130px;
    text-align: center;
}
.button_cont{
    width: 250px;
    height: 45px;
    background: var(--Button, #2A2A2A);
    color: #FAFAFA;
    font-family: 'Roboto';
    font-size: 20px;
    font-style: normal;
    font-weight: 400;
    line-height: normal;    
    border: none;
    border-radius: 8px;
    cursor: pointer;
    margin-left:20px;
} 

#txt_signup_position {
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


    #txt_signup_position :focus{
        outline: none;
        border-color: #007bff; /* Change the border color on focus */
    } 
    
    #txt_signup_position::placeholder{
        color: #BABABA;
        font-family:'Roboto';
        font-size: 14px;
        font-style:normal;
        font-weight: 400;
        line-height: normal;
    }

    .input_label_signup{
        color: #000;
        font-family: 'Roboto';
        font-size: 16px;
        font-style: normal;
        font-weight: 300;
        line-height: normal;
        margin-bottom:20px;
    }

</style>
<h1 class="signup_title">Provide Your Position Details</h1>
<form method="post" action="{{ route('signup_lecturer') }}">
    @csrf
    <!-- Add fields specific to the lecturer, e.g., position -->

    <div class="input_label_signup">
        <label for="signup_position">Position</label>
    </div>
    <input type="text" id="txt_signup_position" name="position" placeholder="Eg: Senior Lecturer" required>

    <!-- Add other fields as needed -->
    <button class=button_general type="submit">Continue</button>
</form>

<span  class = help_txt >Already have an account?<a href="{{route('login')}}">{{ __('Login')}}</a><span>
@endsection