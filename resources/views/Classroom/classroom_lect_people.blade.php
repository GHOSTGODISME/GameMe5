@extends('Layout/classroom_lect_specify_master')

@section('title', 'Classroom')

@section('content')
<style>

.people-page a {
    text-decoration: underline;
    /* Add any other styles for the current page link */
    }

.people-list {
    display: flex;
    flex-direction: column;
    justify-content: space-between;
}

.people-container {
    width: 48%;
    padding: 10px;
    margin-top: 20px;
    background-color: #f2f2f2; /* Background color for the container */
    border-radius: 8px; /* Optional: Add border-radius for rounded corners */
}

.people-container h3 {
    padding-bottom: 10px;
    margin-bottom: 10px;
}

.person {
    margin-bottom: 10px;
    border: 1px solid #ddd;
    background-color: #f9f9f9; /* Background color for each person */
    padding: 10px; /* Optional: Add padding for spacing */
    border-radius: 4px; /* Optional: Add border-radius for rounded corners */
}

</style>

<!-- Display Lecturers and Students -->
<div class="people-list">
    <div class="people-container">
        <h3>Lecturers</h3>
        @foreach ($lecturers as $lecturer)
            <div class="person">
                <p>{{ $lecturer->user->name }}</p>
                <!-- Add other user details as needed -->
            </div>
        @endforeach
    </div>

    <div class="people-container">
        <h3>Students</h3>
        @foreach ($students as $student)
            <div class="person">
                <p>{{ $student->user->name }}</p>
                <!-- Add other user details as needed -->
            </div>
        @endforeach
    </div>
</div>


<script>
</script>
@endsection