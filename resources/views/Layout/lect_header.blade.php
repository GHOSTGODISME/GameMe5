<style>
    .header_container{
        width:100%;
        height:100px;
        display:flex;
        justify-content: space-between;
        background: linear-gradient(to right, #13C1B7, #87DFA8);
    } 
    
    .logo{
        width: 200px;
        height: 50px;
        flex-shrink: 0;
        margin-top:30px;
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
        width: 300px;
        height: 100%;
        background: #3CCBC3;;
        transition: right 0.3s ease;
        z-index: 1;
    }

    .nav-link {
        padding: 15px 15px 0 15px;
        color: #fff;
        text-decoration: none;
        display: block;
        font-family: 'Roboto';
        font-size: 30px;
        font-style: normal;
        font-weight: 400;
        line-height: normal;
        
    }

    .close-icon {
        position: absolute;
        top: 25px;
        right: 20px;
        width: 35px;
        height: 35px;
        cursor: pointer;
    
    }
    .nav_row{
        display: flex;
        flex-direction: row;
        padding-left:20px;
        padding-right:10px;
        align-items: flex-end;
        margin-top:40px;
    }


</style>
    <div class="header_container">
        <a href="{{ url('/lect_homepage') }}"><img class="logo" src="{{ asset('img/logo_header.png') }}" alt="Logo"></a>
        <img class="hamburger" src ="img/hamburger.png" alt="favicon"  onclick="toggleNavigation()">
    </div>
    
<div class="navigation-panel">
    <div class="nav_row">
    <img src="img/close_icon.png" alt="Close" class="close-icon" onclick="toggleNavigation()"><br>
    </div>
    <div class="nav_row">
    <img src="img/profile_icon.png" alt="profile_icon">
    <a href="{{route('stud_profile')}}" class="nav-link">Profile</a>
    </div>
    <div class="nav_row">
    <img src="img/quiz_icon.png" alt="quiz_icon">
    <a href="#" class="nav-link">Quiz</a>
    </div>
    <div class="nav_row">
    <img src="img/classroom_icon.png" alt="classroom_icon">
    <a href="#" class="nav-link">Classroom</a>
    </div>

    <div class="nav_row">
        <img src="img/feedback_icon.png" alt="feedback_icon">
        <a href="#" class="nav-link">Feedback</a>
    </div>

    <div class="nav_row">
        <img src="img/session_icon.png" alt="session_icon">
        <a href="#" class="nav-link">Session</a>
    </div>

    <div class="nav_row">
        <img src="img/tools_icon.png" alt="tools_icon">
        <a href="#" class="nav-link">Tools</a>
    </div>

    <div class="nav_row">
        <img src="img/report_icon.png" alt="report_icon">
        <a href="#" class="nav-link">Report</a>
    </div>


    <!-- Add more navigation links as needed -->
</div>

<script>
    function toggleNavigation() {
        var navigationPanel = document.querySelector('.navigation-panel');
        navigationPanel.style.right = navigationPanel.style.right === '0px' ? '-300px' : '0px';
    }
</script>