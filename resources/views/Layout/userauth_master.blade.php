<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
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
    }
    .content{
    height: 100%;
    width: 40%;
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