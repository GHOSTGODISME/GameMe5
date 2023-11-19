@extends('Layout/userauth_master')

@section('title', 'Sign Up')

@section('content')
<style>
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

.select_acc{
    width: 250px;
    height: 45px;
    border-radius: 8px;
    background: var(--Secondary, #232946);
    color: #FAFAFA;
    font-family: 'Roboto';
    font-size: 20px;
    font-style: normal;
    font-weight: 400;
    line-height: normal; 
    text-align: center;   
    appearance: none;
    -webkit-appearance: none;
    -moz-appearance: none;

}

/* Style for the custom select container */
.custom-select {
    position: relative;
    display: inline-block;
    margin-bottom:30px;
    margin-left:20px;
}

/* Style for the custom arrow */
.custom-arrow {
    position: absolute;
    top: 50%;
    right: 10px;
    transform: translateY(-50%);
    width: 0;
    height: 0;
    border-style: solid;
    border-width: 12px 8px 0; /* Increase the values to make the arrow bigger */
    border-radius:2px;
    border-color: #FAFAFA transparent transparent transparent;
    pointer-events:none; /* Ensure the arrow doesn't interfere with the select */
}

.signup_title{
    color: #000;
    font-family: 'Roboto';
    font-size: 25px;
    font-style: normal;
    font-weight: 500;
    line-height: normal;
    margin-bottom:50px;
    margin-top:130px;
}

</style>

<h1 class="signup_title">Choose Your Account Type</h1>

<form method="post" action="{{ route('signup_1') }}">
    @csrf
    <!-- Add fields for the initial step, including account type -->
    <div class="custom-select">
        <select name="accountType" class="select_acc">
            <option value="student">Student</option>
            <option value="lecturer">Lecturer</option>
        </select>
        <div class="custom-arrow"></div>
    </div>
    
    <!-- Add other fields as needed -->
    <button class=button_cont type="submit">Continue</button>
</form>

<span  class = help_txt >Already have an account?<a href="{{route('login')}}">{{ __('Login')}}</a><span>
@endsection