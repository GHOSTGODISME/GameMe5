@extends('Layout/userauth_master')

@section('title', 'Sign Up')

@section('content')
<style></style>
<h1>Sign<br>Up!</h1>
<form method="post" action="{{ route('signup_2') }}">
    @csrf
    <!-- Add fields for the second step, e.g., email -->
    <label for="email">Email:</label>
    <input type="email" name="email" required>
    <!-- Add other fields as needed -->
    <button type="submit">Next</button>
</form>
<span>Already have an account?<a href="{{route('login')}}">{{ __('Login')}}</a><span>
@endsection