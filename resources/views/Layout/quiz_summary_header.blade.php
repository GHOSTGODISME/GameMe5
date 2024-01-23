<style scoped>
    .header-container {
        width: 100%;
        height: 100px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        background: #252525;
        color: white;
        padding: 30px;
        flex-wrap: wrap;
    }

    .header-quiz-title {
        font-weight: bold;
        font-size: 32px;
        color: white;
        margin-right:110px;
    }

    @media (max-width: 767px){

    .header_container {
        width: 100%;
        height: 10vh;
        padding: 10px;
    }

    .logo{
        width:30vw;
        margin-left:10px;
    }

    .header-quiz-title {
        font-size: 15pt;
        margin-right:20px;
    }


    }
</style>

<div class="header_container">
<img class="logo" src="{{ asset('img/logo_header.png') }}" alt="Logo">
    
    <p class="header-quiz-title">@yield('quizTitle')</p>
</div>



