<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap">
    <title>@yield('title', 'GameMe5')</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Bubblegum+Sans&display=swap">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    
<!-- Add these scripts to the head of your HTML document -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>

<!-- Bootstrap CSS -->
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">

<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>

</head>
<style>
       html,body{
        margin: 0;
        padding: 0;
        height: 100%;
    }

    .content{
    margin-left:90px;
    margin-top:30px; 
    margin-right:90px; 
    padding-bottom:50px;
    }

    .title_container{
        display:flex;
        flex-direction:row;
        width:100%;
        margin-top:40px;
    }

    .nav_container{
        display: flex;
        flex-direction: row;
        align-items: center;
    }

    .class_name{
        margin-left:100px;
    }

    .class_name, .class_coursecode{
        font-family: 'Roboto';
        font-size: 25px;
        font-style: normal;
        font-weight: 500;
        line-height: normal;    
        color: #000;
    
    }


    .class_subtitle1{
        color: #5C5C5C;
        font-family: 'Roboto';
        font-size: 16px;
        font-style: normal;
        font-weight: 400;
        line-height: normal;    
        
    }
    .class_subtitle2,.class_subtitle3,.class_subtitle4,.class_subtitle5,.class_subtitle6{
        color: #5C5C5C;
        font-family: 'Roboto';
        font-size: 16px;
        font-style: normal;
        font-weight: 400;
        line-height: normal;
        margin-left:50px;
    }
   
    .class_subtitle1 a,.class_subtitle2 a,.class_subtitle3 a,.class_subtitle4 a,.class_subtitle5 a,.class_subtitle6 a{
        text-decoration: none;
        color: #5C5C5C;
        font-family: 'Roboto';
        font-size: 16px;
        font-style: normal;
        font-weight: 400;
        line-height: normal;
    }

    .big_con{
        display:flex;
        flex-direction:row;
        justify-content: space-between;
        margin-bottom:10px;
        margin-top:30px;
    }

    .add_icon{
        width:30px;
        height:30px;
        align-self: center;
    }

    .sub_cont{
    display: flex;
    flex-direction: row;   
    align-items: center;
    
    }


</style>

<body>
@include('Layout/lect_header')

<div class="content">
    <div class="title_container">
<h1 class="class_coursecode">{{ $classroom->coursecode }} (G{{ $classroom->group }})</h1>
<h1 class="class_name">{{ $classroom->name }} </h1>
</div>

<div class="big_con">

<div class = "nav_container">
    <h3 class="class_subtitle1 {{ in_array(request()->route()->getName(), ['class_lect_stream']) ? 'stream-page' : '' }}">
        <a href="{{ route('class_lect_stream', ['classroom' => $classroom->id]) }}">Stream</a>
    </h3>

    <h3 class="class_subtitle2 {{ in_array(request()->route()->getName(), ['class_lect_quiz']) ? 'quiz-page' : '' }}">
        <a href="{{ route('class_lect_quiz', ['classroom' => $classroom->id]) }}">Quiz</a>
    </h3>

    <h3 class="class_subtitle3 {{ in_array(request()->route()->getName(), ['class_lect_qna','class_lect_specify_qna']) ? 'qna-page' : '' }}">
        <a href="{{ route('class_lect_qna', ['classroom' => $classroom->id]) }}">Q&A</a>
    </h3>

    <h3 class="class_subtitle4 {{ in_array(request()->route()->getName(), ['class_lect_polls','class_lect_specify_polls']) ? 'polls-page' : '' }}">
        <a href="{{ route('class_lect_polls', ['classroom' => $classroom->id]) }}">Polls</a>
    </h3>

    <h3 class="class_subtitle5 {{ in_array(request()->route()->getName(), ['class_lect_feedback']) ? 'feedback-page' : '' }}">
        <a href="{{ route('class_lect_feedback', ['classroom' => $classroom->id]) }}">Feedback</a>
    </h3>

    <h3 class="class_subtitle6 {{ in_array(request()->route()->getName(), ['class_lect_people']) ? 'people-page' : '' }}">
        <a href="{{ route('class_lect_people', ['classroom' => $classroom->id]) }}">People</a>
    </h3>

</div>

<div class="sub_cont">
    <a href="#" data-toggle="modal" data-target="#addAnnouncementModal">
        <img class="add_icon" src="{{ asset('img/add_icon.png') }}" alt="add_favicon">
    </a>
</div>
</div>

    <!-- Page Content -->
    @yield('content')
</div>       
</body>

<!-- Modal -->
<div class="modal fade" id="addAnnouncementModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Add New Announcement</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Add your form for adding a new announcement here -->
                <form id="addAnnouncementForm" action="{{ route('class_add_announcement') }}" method="post">
                    @csrf 
                    <input type="hidden" name="classId" value="{{ $classroom->id }}">
                    <!-- Announcement Type -->
                    <div class="form-group">
                        <label for="announcementType">Announcement Type</label>
                        <select class="form-control" id="announcementType" name="announcementType">
                            <option value="text">Text Announcement</option>
                            <option value="qna">Q&A Announcement</option>
                            <option value="polls">Polls Announcement</option>
                            <!-- Add other announcement types as needed -->
                        </select>
                    </div>

                    <!-- Content Field (Common to all types) -->
                    <div class="form-group" id="contentField">
                        <label for="content">Content</label>
                        <textarea class="form-control" id="content" name="content"></textarea>
                    </div>

                    <!-- Q&A Specific Fields -->
                    <div class="form-group" id="qnaFields" style="display: none;">
                        <label for="question">Question</label>
                        <input type="text" class="form-control" id="qna_question" name="qna_question">
                        <!-- Add other Q&A fields as needed -->
                    </div>

                    <!-- Q&A Specific Fields -->
                    <div class="form-group" id="pollsFields" style="display: none;">
                        <label for="question">Question</label>
                        <input type="text" class="form-control" id="polls_question" name="polls_question">

                    <label for="option1">Option 1</label>
                    <input type="text" class="form-control" id="option1" name="option1">

                    <label for="option2">Option 2</label>
                    <input type="text" class="form-control" id="option2" name="option2">
                        <!-- Add other Q&A fields as needed -->
                    </div>

                    <!-- Add other specific fields for different announcement types -->

                    <button type="submit" class="btn btn-primary">Save Announcement</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    // Add event listener for type change
    document.getElementById('announcementType').addEventListener('change', function () {
        // Hide all fields
        document.getElementById('contentField').style.display = 'none';
        document.getElementById('qnaFields').style.display = 'none';
        // Add other fields here

        // Show fields based on the selected type
        if (this.value === 'text') {
            document.getElementById('contentField').style.display = 'block';
        } else if (this.value === 'qna') {
            document.getElementById('qnaFields').style.display = 'block';
        }else if(this.value === 'polls'){
            document.getElementById('pollsFields').style.display = 'block';
        }
        // Add other conditions for different types
    });
</script>


</html>