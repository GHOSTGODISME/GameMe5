<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap">

<style>
    .header_container{
        width:100%;
        height:100px;
        display:flex;
        justify-content: space-between;
        background: #252525;
        /* background: linear-gradient(to right, #13C1B7, #87DFA8); */
    } 
    
    .logo{
        width: 180px;
        height: 50px;
        flex-shrink: 0;
        margin-top:25px;
        margin-left:50px;
    }

    .hamburger{
        width: 25px;
        height: 25px;
        flex-shrink: 0;
        margin-top:40px;  
        margin-right:30px;
        cursor: pointer; /* Add cursor style to indicate it's clickable */
    }

     /* Navigation panel styles */
     .navigation-panel {
     
        position: fixed;
        top: 0;
        right: -300px; /* Initially off-screen */
        width: 200px;
        height: 100%;
        background: #313131;
        transition: right 0.3s ease;
        z-index: 1000; /* Set a higher z-index value */
        border-radius:8px;
    }

    .nav-link {
        padding: 15px 15px 0 15px;
        color: #ffffff;
        text-decoration: none;
        display: block;
        font-family: 'Roboto';
        font-size: 20px;
        font-style: normal;
        font-weight: 400;
        line-height: normal;
        
    }


    .nav-link:hover {
        padding: 15px 15px 0 15px;
        color: #ffffff;
        text-decoration: none;
        display: block;
        font-family: 'Roboto';
        font-size: 22px;
        font-style: normal;
        font-weight: 400;
        line-height: normal;
        
    }

    .close-icon {
        position: absolute;
        top: 25px;
        right: 20px;
        width: 25px;
        height: 25px;
        cursor: pointer;
    
    }
    .nav_row{
        display: flex;
        flex-direction: row;
        padding-left:20px;
        padding-right:10px;
        align-items: flex-end;
        margin-top:30px;
    }

    
    .menu_icons{
        width:40px;
        height:40px;
    }


</style>
    <div class="header_container">
        <a href="{{ url('/lect_homepage') }}"><img class="logo" src="{{ asset('img/logo_header.png') }}" alt="Logo"></a>
        <img class="hamburger" src ="{{ asset('img/hamburger.png') }}" alt="favicon"  onclick="toggleNavigation()">
    </div>
    <div class="navigation-panel">
        <div class="nav_row">
            <img src="{{ asset('img/close_icon.png') }}" alt="Close" class="close-icon" onclick="toggleNavigation()"><br>
        </div>
        <div class="nav_row">
            <img  class="menu_icons" src="{{ asset('img/profile_icon.png') }}" alt="profile_icon">
            <a href="{{ route('lect_profile') }}" class="nav-link">Profile</a>
        </div>
        <div class="nav_row">
            <img class="menu_icons" src="{{ asset('img/quiz_icon.png') }}" alt="quiz_icon">
           <a href="{{ route('own-quiz') }}" class="nav-link">Quiz</a>
        </div>
        <div class="nav_row">
            <img class="menu_icons" src="{{ asset('img/classroom_icon.png') }}" alt="classroom_icon">
            <a href="{{ route('classroom_lect_home') }}" class="nav-link">Classroom</a>
        </div>
        <div class="nav_row">
            <img class="menu_icons" src="{{ asset('img/feedback_icon.png') }}" alt="feedback_icon">
            <a href="{{ route('survey-index') }}" class="nav-link">Survey</a>
        </div>
        <div class="nav_row">
            <img class="menu_icons" src="{{ asset('img/session_icon.png') }}" alt="session_icon">
            <a href="{{ route('interactive-session-index') }}" class="nav-link">Session</a>
        </div>
        <div class="nav_row">
            <img class="menu_icons" src="{{ asset('img/tools_icon.png') }}" alt="tools_icon">
            <a href="{{ route('fortune-wheel-index') }}" class="nav-link">Tools</a>
        </div>
        <div class="nav_row">
            <img class="menu_icons" src="{{ asset('img/report_icon.png') }}" alt="report_icon">
            <a href="{{ route('report_home') }}" class="nav-link">Report</a>
        </div>
        <!-- Add more navigation links as needed -->
    </div>
    

<script>
    function toggleNavigation() {
        var navigationPanel = document.querySelector('.navigation-panel');
        navigationPanel.style.right = navigationPanel.style.right === '0px' ? '-300px' : '0px';
    }
</script>