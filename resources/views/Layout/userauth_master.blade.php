<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap">
    <title>@yield('title', 'GameMe5')</title>
    <script src="https://cdn.rawgit.com/davidshimjs/qrcodejs/gh-pages/qrcode.min.js"></script>
    <script src="https://cdn.rawgit.com/cozmo/jsQR/master/dist/jsQR.js"></script>
</head>
<style>
    html,body{
        margin: 0;
        padding: 0;
        min-width: 320px; /* Set a minimum width for the body */
        min-height: 480px; /* Set a minimum height for the body */
    }
   body {
    display: flex;
    flex-direction: row;
    background: #FAFAFA;
    font-family: 'Roboto', sans-serif;
    height:100%;
    }
    .content{
    padding-top:50px;
    margin-left: 5%;
    margin-right: 5%;
    }
    body {
    font-family: 'Roboto', sans-serif;
    }
    
    .header{
        font-size: 4.125em;
    }

    .help_txt{
    color: #000;
    font-family: 'Roboto';
    font-size: 0.75em;
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
    font-size: 0.85em;
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
        font-size: 1.5em;
        font-style: normal;
        font-weight: 500;
        line-height: normal;  
    }

    
    @media only screen and (max-width: 768px) {
    .header {
        font-size: 1.5em; /* Adjust font size for small screens */
    }

    .button_general {
        font-size: 1em; /* Adjust font size for small screens */
    }
    body {
    display: flex;
    flex-direction: column;
    }
    .content {
        padding-top: 20px;
        margin-left: 5%;
        margin-right: 5%;
    }

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

