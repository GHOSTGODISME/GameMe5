@extends('Layout/student_master')

@section('title', 'Homepage')

@section('content')
<style>

body{
    background: linear-gradient(to right, #00C6FF, #0082FF, #0072FF);  
}

.stud_big_cont{
    display:flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
}

#txt_game_code{
    padding: 25px 15px 20px 15px;
    border: 1px solid #BFBFBF;
    border-radius: 10px;
    box-sizing: border-box;
    background: #FAFAFA;
    width: 500px;
    height: 40px;
    flex-shrink: 0;
    margin-top:30px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-family: 'Roboto', sans-serif; /* Replace 'Your Font' with the desired font name */
    font-size: 25px; /* Adjust the font size as needed */
    font-weight: bold; /* Adjust the font weight as needed */
    text-align: center; /* Center the text horizontally */
}

#txt_game_code:focus{
    outline: none;
    border-color: #007bff; /* Change the border color on focus */
} 
    
#txt_game_code::placeholder{
    color: #A3A3A3;
    font-family:'Roboto';
    font-size: 25px;
    font-style:normal;
    font-weight: 400;
    line-height: normal;
    text-align: center;
}

.stud_sub_header{
color: var(--Logo-Secondary, #FAFAFA);
font-family: 'Bubblegum Sans';
font-size: 40px;
font-style: normal;
font-weight: 400;
line-height: normal;
}
</style>

<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

<form action="{{ route('game_session') }}" method="POST">
    @csrf
<div class="stud_big_cont">
    <img src="img/logo_stud.png" alt="logo">
    <input type="text" id="txt_game_code" name="gamecode" placeholder="Game Code">
    <button type="submit" class="button_general">Enter</button>
</div>
</form>

<div class="stud_sub_cont">
    <h1 class = "stud_sub_header">Classroom</h1>
    <!--Classroom List-->

</div>

@endsection
