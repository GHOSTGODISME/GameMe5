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

    .nav_container{
        display: flex;
        flex-direction: row;
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

</style>

<body>
@include('Layout/student_header')

<div class="content">
<div class="title_container">
<h1 class="class_coursecode">{{ $classroom->coursecode }} (G{{ $classroom->group }})</h1>
<h1 class="class_name">{{ $classroom->name }} </h1>

</div>

<div class = "nav_container">
    <h3 class="class_subtitle1 {{ in_array(request()->route()->getName(), ['class_stud_stream']) ? 'stream-page' : '' }}">
        <a href="{{ route('class_stud_stream', ['classroom' => $classroom->id]) }}">Stream</a>
    </h3>

    <h3 class="class_subtitle2 {{ in_array(request()->route()->getName(), ['class_stud_quiz']) ? 'quiz-page' : '' }}">
        <a href="{{ route('class_stud_quiz', ['classroom' => $classroom->id]) }}">Quiz</a>
    </h3>

    <h3 class="class_subtitle3 {{ in_array(request()->route()->getName(), ['class_stud_qna','class_specify_qna']) ? 'qna-page' : '' }}">
        <a href="{{ route('class_stud_qna', ['classroom' => $classroom->id]) }}">Q&A</a>
    </h3>

    <h3 class="class_subtitle4 {{ in_array(request()->route()->getName(), ['class_stud_polls','class_specify_polls']) ? 'polls-page' : '' }}">
        <a href="{{ route('class_stud_polls', ['classroom' => $classroom->id]) }}">Polls</a>
    </h3>

    <h3 class="class_subtitle5 {{ in_array(request()->route()->getName(), ['class_stud_feedback']) ? 'feedbacck-page' : '' }}">
        <a href="{{ route('class_stud_feedback', ['classroom' => $classroom->id]) }}">Feedback</a>
    </h3>

    <h3 class="class_subtitle6 {{ in_array(request()->route()->getName(), ['class_stud_people']) ? 'people-page' : '' }}">
        <a href="{{ route('class_stud_people', ['classroom' => $classroom->id]) }}">People</a>
    </h3>

</div>

    <!-- Page Content -->
    @yield('content')
</div>       
</body>
</html>