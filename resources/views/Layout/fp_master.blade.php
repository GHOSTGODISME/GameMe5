<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap">
    <title>@yield('title', 'GameMe5')</title>
</head>
<style>
    html,body{
        margin: 0;
        padding: 0;
        height: 100%;
    }
    body {
    font-family: 'Roboto', sans-serif;
    background: #FAFAFA; 
    text-align: center; 
    }
    
    .header{
      font-size: 46px;  
    }

    .fp_desc{
        color: #000;
        font-size: 14px;
        font-style:normal;
        font-weight: 400;
        line-height: normal;
    }
    
#txt_forgetpassword_email, #txt_forgetpassword_vc,#txt_new_password,#txt_confirm_new_password{
        padding: 15px;
        border: 1px solid #BFBFBF;
        border-radius: 10px;
        box-sizing: border-box;
        background: #FAFAFA;  
        width: 300px;
        height: 34px;
        flex-shrink: 0;
    }
    #txt_forgetpassword_email,#txt_forgetpassword_vc,#txt_confirm_new_password{
    margin-bottom: 10px;
    }
    #txt_new_password{
        margin-bottom: 30px;
    }

    #txt_forgetpassword_email:focus,#txt_forgetpassword_vc:focus,#txt_new_password:focus,#txt_confirm_new_password:focus{
        outline: none;
        border-color: #007bff; /* Change the border color on focus */
    } 
    
    #txt_forgetpassword_email::placeholder, #txt_forgetpassword_vc::placeholder, #txt_new_password::placeholder, #txt_confirm_new_password::placeholder{
        color: #BABABA;
        font-family:'Roboto';
        font-size: 14px;
        font-style:normal;
        font-weight: 400;
        line-height: normal;
    }

    .input_label{
    color: #000;
    font-family: 'Roboto';
    font-size: 16px;
    font-style: normal;
    font-weight: 300;
    line-height: normal;
    margin-bottom:10px;
    display: flex;
    justify-content: center
    }

    .input_label_small{
        width:300px;
        display: flex;
        justify-content: left;
    }

    .help_txt{
    color: #000;
    font-family: 'Roboto';
    font-size: 12px;
    font-style: normal;
    font-weight: 300;
    line-height: normal;
    }

    .hypertext{
    color: #000;
    font-family: 'Roboto';
    font-size: 12px;
    font-style: normal;
    font-weight: 300;
    line-height: normal;
    text-decoration-line: underline; 
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
        margin-bottom:20px;
    }

</style>
<body>
@include('Layout/fp_header')
<div class="content">
    <!-- Page Content -->
    @yield('content')
</div>
</body>
</html>