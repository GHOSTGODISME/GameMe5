<style>
    .header_container{
        width:100%;
        height:100px;
        display:flex;
        justify-content: space-between;
        background: linear-gradient(to right, #00C6FF, #0082FF, #0072FF);
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
        background: #0195FF;
        transition: right 0.3s ease;
        z-index: 1000; /* Set a higher z-index value */
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
        margin-top:30px;
    }
</style>

<div class="header_container">
    <a href="{{ url('/stud_homepage') }}"><img class="logo" src="{{ asset('img/logo_header.png') }}" alt="Logo"></a> 
    <img class="hamburger" src ="{{ asset('img/hamburger.png') }}" alt="favicon"  onclick="toggleNavigation()">
</div>

<div class="navigation-panel">
    <div class="nav_row">
        <img src="{{ asset('img/close_icon.png') }}" alt="Close" class="close-icon" onclick="toggleNavigation()"><br>
    </div>
    <div class="nav_row">
        <img src="{{ asset('img/profile_icon.png') }}" alt="profile_icon">
        <a href="{{ route('stud_profile') }}" class="nav-link">Profile</a>
    </div>
    <div class="nav_row">
        <img src="{{ asset('img/quiz_icon.png') }}" alt="quiz_icon">
        <a href="#" class="nav-link">Quiz</a>
    </div>
    <div class="nav_row">
        <img src="{{ asset('img/classroom_icon.png') }}" alt="classroom_icon">
        <a href="{{ route('classroom_stud_home') }}" class="nav-link">Classroom</a>
    </div>
    <!-- Add more navigation links as needed -->
</div>


<script>
    function toggleNavigation() {
        var navigationPanel = document.querySelector('.navigation-panel');
        navigationPanel.style.right = navigationPanel.style.right === '0px' ? '-300px' : '0px';
    }
</script>
