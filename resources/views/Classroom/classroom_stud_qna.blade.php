@extends('Layout/classroom_specify_master')

@section('title', 'Classroom')

@section('content')
<style>

.qna-page a {
    text-decoration: underline;
    /* Add any other styles for the current page link */
    }

.annQna{
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
        @case('AnnQna')
            <!-- Display AnnQuiz content -->
            <div class="annQna">
                <div class="ann_header">
              
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
                @php
                $comments = count( $announcement->annQna->replies);
                @endphp
                <p>{{ $comments }} comments</p>
                </div>
            </div>
            @break
    
    @endswitch
@endforeach

<script>
    function redirect(url) {
        window.location.href = url;
    }
</script>
@endsection