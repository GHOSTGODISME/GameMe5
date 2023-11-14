@extends('Layout/userauth_master')

@section('title', 'Sign Up')

@section('content')
<style></style>
<h1>Provide Your Position</h1>
<form method="post" action="{{ route('signup_lecturer') }}">
    @csrf
    <!-- Add fields specific to the lecturer, e.g., position -->
    <label for="position">Position:</label>
    <input type="text" name="position" required>
    <!-- Add other fields as needed -->
    <button type="submit">Next</button>
</form>

<span>Already have an account?<a href="{{route('login')}}">{{ __('Login')}}</a><span>
@endsection