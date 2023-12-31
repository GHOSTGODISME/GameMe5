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

    <a href="{{ route('fortune-wheel-index') }}" class="btn btn-primary">View Wheels</a>
    {{-- <a href="{{ route('quiz-edit') }}" class="btn btn-primary">quiz-edit</a> --}}
    <a href="{{ route('quiz-index') }}" class="btn btn-primary">quiz-index</a>
    <a href="{{ route('survey-index') }}" class="btn btn-primary">surveys</a>
    <a href="{{ route('survey-index') }}" class="btn btn-primary">surveys</a>
    <a href="{{ route('interactive-session-index') }}" class="btn btn-primary">interactivesession</a>

    <form method="GET" action="{{ route('join-quiz') }}">
        <input type="text" name="code">
        <button type="submit">Confirm</button>
    </form>

    <form method="GET" action="{{ route('join-interactive-session') }}">
        <input type="text" name="code">
        <button type="submit">Confirm</button>
    </form>

</body>
<script>
    // Check for error message in session
    let errorMessage = "{{ session('error') }}";

    // Display alert if error message exists
    if (errorMessage) {
        alert(errorMessage);
    }
</script>

</html>