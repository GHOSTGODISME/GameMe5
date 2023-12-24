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
    body{
    display: flex;
    flex-direction:row;
    background: #FAFAFA;    
    }
    .content{
    width:20%;
    padding-top:50px;
    margin-left: 50px;
    margin-right: 80px;
    }
    body {
    font-family: 'Roboto', sans-serif;
    }
    
    .header{
      font-size: 66px;  
    }

    .help_txt{
    color: #000;
    font-family: 'Roboto';
    font-size: 12px;
    font-style: normal;
    font-weight: 300;
    line-height: normal;
    width:300px;
    display: flex;
    margin-top:15px;
    justify-content: center;
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
    }

</style>
<body>
@include('Layout/half_page_logo')
<div class="content">
    <!-- Page Content -->
    @yield('content')
</div>
</body>
</html>

