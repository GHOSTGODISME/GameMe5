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
    .nav_container{
        display: flex;
        flex-direction: row;

    }
</style>
<body>
@include('Layout/lect_header')
<div class="content">
<h1> Admin Dashboard </h1>
<div class = nav_container>
    <h3>Students</h3>
    <h3>Staff</h3>
</div>
    <!-- Page Content -->
    @yield('content')
</div>
</body>
</html>