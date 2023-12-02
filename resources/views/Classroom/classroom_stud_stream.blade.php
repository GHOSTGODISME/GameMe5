@extends('Layout/classroom_specify_master')

@section('title', 'Classroom')

@section('content')
<style>

.stream-page a {
    text-decoration: underline;
    /* Add any other styles for the current page link */
    }

    .annText, .annQuiz, .annQna, .annPolls, .annFeedback{
        border-radius: 8px;
        border: 1px solid #BFBFBF;
        margin-bottom:30px;
        background: #0195FF;
    }

    .ann_header{
        display: flex;
        flex-direction: row;
        margin:20px 20px 5px 20px;
    
    }

    .ann_header p, .ann_header h1{
        padding: 0;

    }

    .ann_category{
        color: #FAFAFA;
        font-family: 'Roboto';
        font-size: 18px;
        font-style: normal;
        font-weight: 500;
        line-height: normal;
        margin-right:30px;
    }

    .author{
        color: #eeeeee;
        font-family: 'Roboto';
        font-size: 14px;
        font-style: normal;
        font-weight: 500;
        line-height: normal;
    }

    .datetime{
        color: #FAFAFA;
        font-family: 'Roboto';
        font-size: 14px;
        font-style: normal;
        font-weight: 500;
        line-height: normal;
        margin-left:auto;
        margin-right:30px;
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
    font-family: 'Roboto';
    font-size: 14px;
    font-style: normal;
    font-weight: 500;
    line-height: normal;
    text-align: center;
    }

    .ann_content p{
        padding:17px 20px 1px 20px;
  
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
        @case('AnnText')
            <!-- Display AnnText content -->
            <div class="anntext">
                <div class="ann_header">
                <h1 class="ann_category">Announcement</h1>
                <p class="author">{{$announcement->user->name}}<p>
                    <p class="datetime">{{ \Carbon\Carbon::createFromTimestamp(strtotime($announcement->created_at))->format('d/m/Y h:i A')}}</p>
                    
                    @if($announcement->user_id == $currentUser->id)
                    <div class="button-container">
                        <div class="menu-icon" onclick="toggleMenu(this, event)">
                            <img src="{{ asset('img/threedot_white.png')}}" alt="three_dot">
                        </div>
                        <div class="action-menu">
                            <a href="#" data-toggle="modal" data-target="#updateAnnouncementModal" class="updateAnnouncementBtn" onclick="openUpdateModal({{ $announcement->id }})">Update Announcement</a>
                            <a href="#" data-toggle="modal" data-target="#deleteAnnouncementModal" class="deleteAnnouncementBtn" onclick="setAnnouncementId({{ $announcement->id }})">Delete Announcement</a>
                        </div>
                       
                    </div>
                    @endif
                </div>
                <div class="ann_content">
                <p>{{ $announcement->annText->content }}</p>
                </div>
            </div>
            
            @break

        @case('AnnQuiz')
        <div class="annQuiz">
            <div class="ann_header">
            <h1 class="ann_category">Quiz</h1>
            <p class="author">{{$announcement->user->name}}<p>
                <p class="datetime">{{ \Carbon\Carbon::createFromTimestamp(strtotime($announcement->created_at))->format('d/m/Y h:i A')}}</p>
                
                @if($announcement->user_id == $currentUser->id)
                <div class="button-container">
                    <div class="menu-icon" onclick="toggleMenu(this, event)">
                        <img src="{{ asset('img/threedot_white.png')}}" alt="three_dot">
                    </div>
                    <div class="action-menu">
                        <a href="#" data-toggle="modal" data-target="#deleteAnnouncementModal" class="deleteAnnouncementBtn" onclick="setAnnouncementId({{ $announcement->id }})">Delete Announcement</a>
                    </div>
                   
                </div>
                @endif

            </div>

            <div class="ann_content">
            <p> A new quiz has been assigned. Join the quiz now!</p>
            {{-- <p>{{ $announcement->annQuiz->quiz_id }}</p> --}}
            <button class="class_button">Join</button>
            </div>
        </div>
            @break

        @case('AnnQna')
        <div class="annQna">
            <div class="ann_header">
            <h1 class="ann_category">Q&A</h1>
            <p class="author">{{$announcement->user->name}}<p>
                <p class="datetime">{{ \Carbon\Carbon::createFromTimestamp(strtotime($announcement->created_at))->format('d/m/Y h:i A')}}</p>
                
                @if($announcement->user_id == $currentUser->id)
                <div class="button-container">
                    <div class="menu-icon" onclick="toggleMenu(this, event)">
                        <img src="{{ asset('img/threedot_white.png')}}" alt="three_dot">
                    </div>
                    <div class="action-menu">
                        <a href="#" data-toggle="modal" data-target="#updateAnnouncementModal" class="updateAnnouncementBtn" onclick="openUpdateModal({{ $announcement->id }})">Update Announcement</a>
                        <a href="#" data-toggle="modal" data-target="#deleteAnnouncementModal" class="deleteAnnouncementBtn" onclick="setAnnouncementId({{ $announcement->id }})">Delete Announcement</a>
                    </div>
                   
                </div>
                @endif

            </div>
            <div class="ann_content" onclick="redirect('{{ route('class_specify_qna', ['qna' => $announcement->annQna->id]) }}')">
            <p>{{ $announcement->annQna->question }}</p>
            </div>
        </div>

            @break

        @case('AnnPolls')
        <div class="annPolls">
            <div class="ann_header">
            <h1 class="ann_category">Polls</h1>
            <p class="author">{{$announcement->user->name}}<p>
                <p class="datetime">{{ \Carbon\Carbon::createFromTimestamp(strtotime($announcement->created_at))->format('d/m/Y h:i A')}}</p>
                
                @if($announcement->user_id == $currentUser->id)
                <div class="button-container">
                    <div class="menu-icon" onclick="toggleMenu(this, event)">
                        <img src="{{ asset('img/threedot_white.png')}}" alt="three_dot">
                    </div>
                    <div class="action-menu">
                        <a href="#" data-toggle="modal" data-target="#updateAnnouncementModal" class="updateAnnouncementBtn" onclick="openUpdateModal({{ $announcement->id }})">Update Announcement</a>
                        <a href="#" data-toggle="modal" data-target="#deleteAnnouncementModal" class="deleteAnnouncementBtn" onclick="setAnnouncementId({{ $announcement->id }})">Delete Announcement</a>
                    </div>
                   
                </div>
                @endif

            </div>
            <div class="ann_content" onclick="redirect('{{ route('class_specify_polls', ['polls' => $announcement->annPolls->id]) }}')">
            <p>{{ $announcement->annPolls->question }}</p>
            </div>
        </div>
            @break

        @case('AnnFeedback')
        <div class="annFeedback">
            <div class="ann_header">
            <h1 class="ann_category">Feedback</h1>
            <p class="author">{{$announcement->user->name}}<p>
                <p class="datetime">{{ \Carbon\Carbon::createFromTimestamp(strtotime($announcement->created_at))->format('d/m/Y h:i A')}}</p>
                
                @if($announcement->user_id == $currentUser->id)
                <div class="button-container">
                    <div class="menu-icon" onclick="toggleMenu(this, event)">
                        <img src="{{ asset('img/threedot_white.png')}}" alt="three_dot">
                    </div>
                    <div class="action-menu">
                        <a href="#" data-toggle="modal" data-target="#deleteAnnouncementModal" class="deleteAnnouncementBtn" onclick="setAnnouncementId({{ $announcement->id }})">Delete Announcement</a>
                    </div>
                   
                </div>
                @endif

            </div>
            <div class="ann_content">
            <p> A new feedback has been assigned. Fill it now!</p>
            {{-- <p>{{ $announcement->annFeedback->feedback_id }}</p> --}}
            <button class="class_button">Fill now</button>
            </div>
        </div>
            @break

        @default
            <!-- Handle other content types or throw an error -->
    @endswitch
@endforeach


<script>
function redirect(url) {
        window.location.href = url;
    }

</script>
@endsection