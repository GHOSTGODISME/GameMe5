<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <h1>Testing123</h1>
    <a href="{{route('login')}}">{{ __('Login')}}</a>
    {{-- <a href="{{route('createWheel')}}">{{ __('createWheel')}}</a> --}}

    <a href="{{ route('fortune-wheel-main') }}" class="btn btn-primary">View Wheels</a>
    <a href="{{ route('quiz-edit') }}" class="btn btn-primary">quiz-edit</a>
    <a href="{{ route('survey-index') }}" class="btn btn-primary">surveys</a>

</body>
</html>