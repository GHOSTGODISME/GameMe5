@extends('Layout/classroom_specify_master')

@section('title', 'Classroom')

@section('content')
<style>

.people-page a {
    text-decoration: underline;
    /* Add any other styles for the current page link */
    }

    .people-list {
        display: flex;
        justify-content: space-around;
        margin-top: 20px;
    }

    .people-container {
        flex: 0 0 48%;
        padding: 20px;
        background-color: #fff;
        border-radius: 8px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        transition: background-color 0.3s ease;
    }

    .people-container:hover {
        background-color: #f5f5f5;
    }

    .people-container h3 {
        padding-bottom: 10px;
        margin-bottom: 20px;
        border-bottom: 1px solid #ddd;
        color: #333;
    }

    .person {
        margin-bottom: 20px;
        background-color: #f9f9f9;
        padding: 15px;
        border-radius: 8px;
        transition: background-color 0.3s ease;
        display:flex;
        flex-direction: row;
    
        align-items: center; 
    }

    .person p{
        padding-bottom: 0;
        margin-bottom:0;
    }

    .person:hover {
        background-color: #eaeaea;
    }

    .modal-content {
        border-radius: 8px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }

    .modal-footer {
        border-top: 1px solid #ddd;
    }

    .profile_picture {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        border: 2px white solid;
    }

    .person_name{
        margin-left:30px;
        margin-right:auto;
    }


</style>

<!-- Display Lecturers and Students -->
<div class="people-list">
    <!-- Lecturers Container -->
    <div class="people-container">
        <h3>Lecturers</h3>
        @foreach ($lecturers as $lecturer)
            <div class="person">
                <img class="profile_picture" src="{{$lecturer->user->profile_picture}}" alt="Person Image">
                <p class="person_name">{{ $lecturer->user->name }}</p>
                <!-- Add other user details as needed -->
            </div>
        @endforeach
    </div>

    <!-- Students Container -->
    <div class="people-container">
        <h3>Students</h3>
        @foreach ($students as $student)
            <div class="person">
                <img class="profile_picture" src="{{$student->user->profile_picture}}" alt="Person Image">
                <p class="person_name">{{ $student->user->name }}</p>
                <!-- Add other user details as needed -->
            </div>
            <!-- Bootstrap Modal for Each Student -->
            <!-- ... Your existing modal code ... -->
        @endforeach
    </div>
</div>


<script>
</script>
@endsection