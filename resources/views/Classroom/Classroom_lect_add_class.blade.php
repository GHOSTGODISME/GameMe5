@extends('Layout/lect_master')

@section('title', 'Classroom')

@section('content')
<style>

.class_row {
    display: flex;
    flex-direction: row;
    width: 60%;
    justify-content: space-between;
    margin-top:30px;
}

.studE_info {
    width: 300px;
}

.class_input {
    width: 300px;
    border: 1px solid #000;
    border-radius: 8px;
    background: #FFF;
    height: 30px;
    font-size: 14px;
    padding-left: 10px;
}

.comp-button-container {
    display: flex;
    width: 350px;
    justify-content: space-between;
    margin-top: 30px;
}

.confirm-button, .cancel-button {
    cursor: pointer;
    border: none;
}

.confirm-button {
    width: 150px;
    height: 35px;
    margin-top: 40px;
    flex-shrink: 0;
    border-radius: 8px;
    background: var(--Button, #2A2A2A);
    color: #FEFEFE;
    font-family: 'Roboto';
    font-size: 16px;
    font-style: normal;
    font-weight: 500;
    line-height: normal;
}

.cancel-button {
    background-color: #dc3545;
    width: 150px;
    height: 35px;
    margin-top: 40px;
    flex-shrink: 0;
    border-radius: 8px;
    color: #FEFEFE;
    font-family: 'Roboto';
    font-size: 16px;
    font-style: normal;
    font-weight: 500;
    line-height: normal;
    text-decoration: none;
    text-align: center;
    display: flex;
    justify-content: center;
    align-items: center;
}

.cancel-button:hover{
    text-decoration: none;
    color: #FEFEFE;
}

.success_message {
    color: #28a745;
    margin-top: 10px;
}

.classroom_title{
    color: var(--Button, #2A2A2A);
    font-family: 'Roboto';
    font-size: 30px;
    font-style: normal;
    font-weight: 400;
    line-height: normal;
}

.label_class_stud{
    color: #000;
    font-family: 'Roboto';
    font-size: 16px;
    font-style: normal;
    font-weight: 300;
    line-height: normal;
}

.success-modal {
        padding: 30px;
        text-align: center;
    }

    .success-icon {
        width: 80px;
        height: 80px;
        margin-bottom: 20px;
    }

    .success-message {
        font-size: 18px;
        margin-bottom: 10px;
    }

    .join-code {
        font-size: 16px;
        margin-bottom: 20px;
    }

    .close-button {
        width: 120px;
        height: 40px;
        font-size: 16px;
    }

</style>

<div class="title_bar">
    <h1 class="classroom_title">Add Classroom</h1>
</div>

<form action="{{ route('lect_add_classroom') }}" method="POST" class="add_class_form" enctype="multipart/form-data">
    @csrf

    <div class="class_row">
        <div class="studE_info">
            <div class="input_group">
                <p class="label_class_stud">Class Name:</p>
            </div>
            <div><input type="text" class="class_input" name="name"></div>
        </div>

        <div class="studE_info">
            <div class="input_group">
                <p class="label_class_stud">Course code:</p>
            </div>
            <div><input type="text" class="class_input" name="course_code"></div>
        </div>
    </div>

    <div class="class_row">
        <div class="studE_info">
            <div class="input_group">
                <p class="label_class_stud">Group: </p>
            </div>
            <div><input class="class_input" type="text" name="group"></div>
        </div>
    </div>

    <div class="class_row">
        <div class="input_group"></div>
        <div class="comp-button-container">
            <button type="submit" class="confirm-button">Confirm</button>
            <a class="cancel-button" href="{{ route('classroom_lect_home') }}">Cancel</a>
        </div>
    </div>

    @if (session('success_message'))
    <!-- Bootstrap Modal for Success Message -->
<!-- Bootstrap Modal for Success Message -->
<div class="modal fade" id="successModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-body success-modal">
                <div class="text-center">
                    <img src="{{ asset('img/success_icon.png') }}" alt="Success Icon" class="success-icon">
                </div>
                <p class="success-message">{{ session('success_message') }}</p>
                <p class="join-code"><strong>Join Code: {{ session('joinCode') }}</strong></p>
                <button type="button" class="btn btn-primary close-button" data-dismiss="modal">Continue</button>
            </div>
        </div>
    </div>
</div>
        <!-- Show the modal using JavaScript -->
        <script>
            $(document).ready(function () {
                $('#successModal').modal('show');
            });
        </script>
    @endif
</form>

<script>

</script>
@endsection
