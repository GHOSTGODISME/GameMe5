@extends('Layout/classroom_lect_specify_master')

@section('title', 'Classroom')

@section('content')
<style>
    body {
        background-color: #f7f7f7;
        font-family: 'Arial', sans-serif;
        margin: 0;
    }

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

    .person a{
        color: #5C5C5C;
        font-family: 'Roboto';
        font-size: 16px;
        font-style: normal;
        font-weight: 400;
        line-height: normal;
        text-decoration: :none;
    }
    /* Add any other custom styling as needed */
</style>

<!-- Your existing HTML content -->
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
            <img class="profile_picture" src="{{ $student->user->profile_picture }}" alt="Person Image">
            <p class="person_name">{{ $student->user->name }}</p>
            <a href="#" data-toggle="modal" data-target="#confirmRemoveStudentModal-{{ $student->id }}">
                Remove Student
            </a>
            <!-- Add other user details as needed -->
        </div>
    
        <!-- Bootstrap Modal for Each Student -->
        <div class="modal fade" id="confirmRemoveStudentModal-{{ $student->id }}" tabindex="-1" role="dialog" aria-labelledby="confirmRemoveStudentModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="confirmRemoveStudentModalLabel">Remove Student</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p>Are you sure you want to remove {{ $student->user->name }} from the classroom?</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        <a href="{{ route('lect_remove_student', ['id' => $student->id]) }}" class="btn btn-danger">Remove</a>
                        <!-- Replace 'route' with the appropriate route for removing the student -->
                    </div>
                </div>
            </div>
        </div>
    @endforeach
    </div>
</div>

<!-- Add your existing scripts or additional scripts as needed -->
<script>
</script>

@endsection