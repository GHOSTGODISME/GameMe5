@extends('Layout/classroom_specify_master')

@section('title', 'Classroom')

@section('content')
<style>

.feedback-page a {
    text-decoration: underline;
    /* Add any other styles for the current page link */
}

    .annFeedback{
        border-radius: 8px;
        border: 1px solid #353535;
        margin-bottom:30px;
        background: #252525;
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

@foreach ($announcements as $index=> $announcement)
    @switch($announcement->type)
        @case('AnnFeedback')
        <div class="annFeedback">
            <div class="ann_header">
            <h1 class="ann_category">Survey</h1>
            <p class="author">{{$announcement->user->name}}<p>
                <p class="datetime">{{ \Carbon\Carbon::createFromTimestamp(strtotime($announcement->created_at))->format('d/m/Y h:i A')}}</p>
                @if($announcement->user_id == $currentUser->id)
                <div class="button-container">
                    <div class="menu-icon"  id="menuIcon{{ $index }}" onclick="toggleMenu(this, event)">
                        <img src="{{ asset('img/threedot_white.png')}}" alt="three_dot">
                    </div>
                    <div class="action-menu" id="actionMenu{{ $index }}">
                        <a href="#" class="deleteAnnouncementBtn" onclick="deleteAnnouncement({{ $announcement->id }})">Delete Announcement</a>
                    </div>
                   
                </div>
                @endif
            
            </div>
            <div class="ann_content">
            <p> A new survey has been assigned. Fill it now!</p>
            {{-- <p>{{ $announcement->annFeedback->feedback_id }}</p> --}}
            <button class="class_button" onclick="redirect_survey({{ $announcement->annFeedback}})">Fill Now!</button>
            </div>
        </div>
            @break
    
    @endswitch
@endforeach

<script>
    
    function redirect_survey(annfeedback) {
        // Replace 'YOUR_BASE_URL' with the actual base URL of your application
        var baseUrl = 'http://localhost:8000';
        // Assuming you have the session code available (replace 'sessionCode' accordingly)
        var survey_id = annfeedback.survey_id;
        // Generate the link with the session code
        var link = baseUrl + '/get-survey-response/' + survey_id;
        console.log(link);
        // Navigate to the generated link
        window.location.href = link;
        }
</script>
@endsection