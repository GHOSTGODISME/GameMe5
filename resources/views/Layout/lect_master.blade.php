<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap">
    <title>@yield('title', 'GameMe5')</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Bubblegum+Sans&display=swap">
     <!-- jQuery -->
     <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

     <!-- Bootstrap CSS -->
     <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
 
     <!-- Bootstrap JavaScript -->
     <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
     <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
     <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
     <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">

</head>
<style>
    html,body{
        margin: 0;
        padding: 0;
        height: 100%;
    }

    .content{
    margin-left:90px;
    margin-top:30px; 
    margin-right:90px; 
    padding-bottom:50px;
    }
    
    .lect_title{
        color: var(--Button, #2A2A2A);
        font-family: 'Roboto';
        font-size: 30px;
        font-style: normal;
        font-weight: 400;
        line-height: normal;
    }

    
    .lect_subtitle{
        color: #5C5C5C;
        font-family: 'Roboto';
        font-size: 16px;
        font-style: normal;
        font-weight: 400;
        line-height: normal;
    }
    .profile-data_top{
        width: 666px;
        height: 110px;
        flex-shrink: 0;
        border-radius: 15px 15px 0px 0px;
        border: 1px solid #FFF;
        background: #3CCBC3;;
        display: flex;
        align-items: center; /* Vertically center items */
        cursor: pointer;
    }

    .profile-data{
        width: 666px;
        height: 70px;
        flex-shrink: 0;
        border: 1px solid #FFF;
        background: #3CCBC3;;
        display: flex;
        align-items: center; /* Vertically center items */
        justify-content: space-between;
        cursor: pointer;
    }

    .profile-data_low{
        width: 666px;
        height: 70px;
        flex-shrink: 0;
        border-radius: 0px 0px 15px 15px;
        border: 1px solid #FFF;
        background: #3CCBC3;;
        display: flex;
        align-items: center; /* Vertically center items */
        cursor: pointer;
    }

    .profile-data_logout
    {
        width: 666px;
        height: 70px;
        flex-shrink: 0;
        border-radius: 15px;
        border: 1px solid #D05252;
        background: #FFF;
        display: flex;
        align-items: center; /* Vertically center items */
        justify-content: space-between;
        cursor: pointer;
    }

    .profile-big-container{
        display:flex;
        justify-content: space-between;
    }

    .profile-label{
        color: #FEFEFE;
        font-family: 'Roboto';
        font-size: 20px;
        font-style: normal;
        font-weight: 400;
        line-height: normal;
        margin-left:20px;
        width:30%;
    }

    .profile-label_logout{
        color: #D05252;
        font-family: 'Roboto';
        font-size: 20px;
        font-style: normal;
        font-weight: 400;
        line-height: normal;
        margin-left:20px;
        width:30%;
    }

    .profile_output{
        color: #FEFEFE;
        text-align: center;
        font-family: 'Roboto';
        font-size: 16px;
        font-style:normal;
        font-weight: 300;
        line-height: normal;
        display: flex;
        justify-content: space-between;
        width:70%;
        align-items: center;

    }

    .profile_output_email{
        font-family: 'Roboto';
        font-size: 16px;
        font-style: normal;
        font-weight: 300;
        line-height: normal;
        display: flex;
        width:70%;
        margin-right:30px;
        padding-left:10px;
        border-radius: 15px;
        border: 1px solid #9B9B9B;
        background: #E0E0E0;
        padding-top:5px;
        padding-bottom:5px;
        color: #5C5C5C;
    }

    .edit-button {
        margin-right:10px;
        width: 20px;
        height: 20px;
        background: url('img/right_icon.png') center/cover no-repeat; 
        border: none;
        cursor: pointer;
    }

    .logout-button{
        margin-right:10px;
        width: 20px;
        height: 20px;
        background: url('img/logout_icon.png') center/cover no-repeat; 
        border: none;
        cursor: pointer;
    }

    .profile_pic_con{
        display:flex;
        flex-direction: row;
        align-items: center;
    }

    .button_general{
    width: 300px;
    height: 45px;
    margin-top:40px;
    flex-shrink: 0;
    border-radius: 8px;
    background: var(--Button, #2A2A2A);
    color: #FEFEFE;
    font-family: 'Roboto';
    font-size: 24px;
    font-style: normal;
    font-weight: 500;
    line-height: normal;  
}

</style>
<body>
@include('Layout/lect_header')
<div class="content">
    <!-- Page Content -->
    @yield('content')
</div>
</body>
</html>