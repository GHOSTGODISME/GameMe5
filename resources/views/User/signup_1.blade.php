@extends('Layout/userauth_master')

@section('title', 'Sign Up')

@section('content')
<style></style>

<h1>Choose Your Account Type</h1>

<form method="post" action="{{ route('signup_1') }}">
    @csrf
    <!-- Add fields for the initial step, including account type -->
    <label for="accountType">Account Type:</label>
    <select name="accountType">
        <option value="student">Student</option>
        <option value="lecturer">Lecturer</option>
    </select>
    <!-- Add other fields as needed -->
    <button type="submit">Next</button>
</form>

<span>Already have an account?<a href="{{route('login')}}">{{ __('Login')}}</a><span>
@endsection