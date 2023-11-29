@extends('Layout/userauth_master')

@section('title', 'Sign Up')

@section('content')
<style>
    
.icon{
width:150px;
height:150px;
margin:0;
padding:0;
margin-bottom:50px;
}

.congrat_txt{
    color: #000;
    text-align: center;
    font-family: 'Roboto';
    font-size: 20px;
    font-style: normal;
    font-weight: 400;
    line-height: normal;
    display: flex;
    flex-direction: column;
    justify-content: center;
    flex-shrink: 0;
}

.icon_container{
    display: flex;
    justify-content: center;
    align-content: center;
    text-align: center;
    align-items: center;
    width:100%;
    flex-direction: column;
    padding-top:100px;
}
.blank{
     height:200px;   
    }
</style>

<div class= "icon_container">
    <img class="icon" src="img/success_icon.png" alt="success_icon"/>
    <p class="congrat_txt">Congratulation, your account has been successfully created.</p>
    <div class=blank></div>
<form action="{{ route('successful_signup') }}" method="GET">
<button class=button_general type="submit">Login Now</button>
</form>
</div>


@endsection