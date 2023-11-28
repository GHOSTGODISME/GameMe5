@extends('Layout/classroom_specify_master')

@section('title', 'Classroom')

@section('content')
<style>

.quiz-page a {
    text-decoration: underline;
    /* Add any other styles for the current page link */
    }

    .annQuiz{
        border-radius: 8px;
        border: 1px solid #BFBFBF;
        margin-bottom:30px;
    }
    .ann_header{
        display: flex;
        flex-direction: row;
        margin:5px 20px 5px 20px;
    }

    .ann_header p, .ann_header h1{
        padding: 0;

    }

    .ann_category{
        color: #000;
        font-family: 'Roboto';
        font-size: 18px;
        font-style: normal;
        font-weight: 500;
        line-height: normal;
        margin-right:30px;
    }

    .author{
        color: #565656;
        font-family: 'Roboto';
        font-size: 14px;
        font-style: normal;
        font-weight: 500;
        line-height: normal;
    }

    .datetime{
        color: #565656;
        font-family: 'Roboto';
        font-size: 14px;
        font-style: normal;
        font-weight: 500;
        line-height: normal;
        margin-left:auto;
    }

    .ann_content{
    display:flex;
    flex-direction: row;
    justify-content: space-between;
    align-items: center;
    border-top: 1px solid #BFBFBF;
    cursor: pointer;
    border-radius: 0px 0px 8px 8px;
    background: #FAFAFA;
    }

    .ann_content p{
        padding:5px 20px 5px 20px;
    }

    .class_button{
        border-radius: 8px;
        background: var(--Button, #2A2A2A); 
        width: 150px;
        height: 30px;
        flex-shrink: 0;
        color: #FFF;
        font-family: 'Bubblegum Sans';
        font-size: 16px;
        font-style: normal;
        font-weight: 400;
        line-height: normal;
        margin-right:20px;
        cursor:pointer;
    }
    
</style>

@foreach ($announcements as $announcement)
    @switch($announcement->type)
        @case('AnnQuiz')
            <!-- Display AnnQuiz content -->
            <div class="annQuiz">
                <div class="ann_header">
                <h1 class="ann_category">Quiz</h1>
                <p class="author">{{$announcement->user->name}}<p>
                    <p class="datetime">{{ \Carbon\Carbon::createFromTimestamp(strtotime($announcement->created_at))->format('d/m/Y h:i A')}}</p>
                </div>
    
                <div class="ann_content">
                <p> A new quiz has been assigned. Join the quiz now!</p>
                {{-- <p>{{ $announcement->annQuiz->quiz_id }}</p> --}}
                <button class="class_button">Join</button>
                </div>
            </div>
            @break
    
    @endswitch
@endforeach

<script>
</script>
@endsection