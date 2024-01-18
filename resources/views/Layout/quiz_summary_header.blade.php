<style scoped>
    .header-container {
        width: 100%;
        height: 100px;
        display: flex;
        align-items: center;
        background: linear-gradient(to right, #00C6FF, #0082FF, #0072FF);
    }

    .header-quiz-title {
        font-weight: bold;
        font-size: 32px;
        color: white;
        margin: auto;
    }
</style>

<div class="header-container">
    <a href="{{ url('/stud_homepage') }}"><img class="logo" src="{{ asset('img/logo_header.png') }}" alt="Logo"></a> 
    
    <p class="header-quiz-title">@yield('quizTitle')</p>
</div>



