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
</style>
<body>
@include('Layout/student_header')
<div class="content">
    <!-- Page Content -->
    @yield('content')
</div>
</body>
</html>