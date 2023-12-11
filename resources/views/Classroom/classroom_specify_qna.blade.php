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
        background: #FFFFFF;
 
    }

    .ann_header{
        display: flex;
        flex-direction: row;
        border-radius: 8px 8px 0 0;
        background: #0195FF;
        padding:20px 20px 5px 20px;

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
        color: #FFFFFF;
        font-family: 'Roboto';
        font-size: 14px;
        font-style: normal;
        font-weight: 500;
        line-height: normal;
    }

    .datetime{
        color: #FFFFFF;
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
        flex-direction: column;
        border-top: 1px solid #BFBFBF;
        cursor: pointer;
        background: #FAFAFA;
        border-bottom: 1px solid #BFBFBF;
        padding-top:10px;
        padding-bottom: 5px;
       
    }

    .ann_content p{
        margin:0;
        padding:0;
    }

    .question{
        color: #000000;
        font-family: 'Roboto';
        font-size: 20px;
        font-style: normal;
        font-weight: 500;
        line-height: normal;
    }

    .comments_qty{
        color: #000000;
        font-family: 'Roboto';
        font-size: 12px;
        font-style: normal;
        font-weight: 500;
        line-height: normal;
    }

    .comment_class{
        display: flex;
        justify-content: end;
  
    }

    .ann_content p{
        padding:5px 20px 5px 20px;
    }

    .qna-reply {
    background: #FFFFFF;
    margin-top: 10px;
    overflow-y: auto;
    max-height: 220px;
    border-radius: 5px; /* Add border-radius for rounded corners */
    padding: 10px 10px 0px 10px; /* Add padding for better appearance */

    }

    .qna-reply .reply {
        padding-bottom: 10px; /* Add some bottom padding for spacing */
    }

    .qna-reply .reply p {
        margin: 0; /* Remove default margin for paragraphs */
    }

    .qna-reply .reply p:first-child {
        margin-bottom: 5px; /* Add some bottom margin for spacing */
    }

    .qna-reply .reply:last-child {
        border-bottom: none; /* Remove bottom border for the last reply */
    }

    .qna-reply::-webkit-scrollbar {
        width: 8px; /* Adjust scrollbar width as needed */
    }

    .qna-reply::-webkit-scrollbar-thumb {
        background-color: #0195FF; /* Color for the scrollbar thumb */
        border-radius: 4px; /* Adjust border-radius for rounded thumb */
    }

    .qna-reply::-webkit-scrollbar-track {
        background-color: #FFFFFF; /* Color for the scrollbar track */
        border-radius: 4px; /* Adjust border-radius for rounded track */
    }
    .qna_add_reply {
        background: #FFFFFF;
        margin-top: 10px; /* Adjust the margin as needed */
        padding: 10px; /* Adjust the padding as needed */
        border: 1px solid #BFBFBF; /* Border around the reply form */
        border-radius: 5px; /* Adjust the border-radius as needed */
        display: flex;
        flex-direction: column;
    }

    .qna_add_reply .textarea-container {
        position: relative;
        border: 1px solid #BFBFBF; /* Add border around the entire container */
        border-radius: 5px; /* Adjust the border-radius as needed */
        overflow: hidden; /* Hide overflow to prevent double border on focus */
    }

    .qna_add_reply textarea {
        width: calc(100% - 20px); /* Adjust the width and subtract padding */
        box-sizing: border-box;
        padding: 10px; /* Adjust the padding as needed */
        border: none; /* Remove the initial textarea border */
        resize: vertical; /* Allow vertical resizing of the textarea */
        margin-bottom: 10px; /* Adjust the margin as needed */
        outline: none; /* Remove the outline on focus */
    }


    .qna_add_reply button {
        position: absolute;
        top: 50%;
        right: 0;
        transform: translateY(-50%);
        padding: 10px; /* Adjust padding for the icon */
        background: none; /* Remove the default button background */
        border: none; /* Remove the button border */
        cursor: pointer;
    }

 
.textarea-container {
    position: relative;
    border-top:1px solid #BFBFBF;
    border-radius:0 0 8px 8px;
    height:36px;
    margin-bottom:10px;
}

.textarea-container textarea {
width: calc(100% - 35px);
    box-sizing: border-box;
    margin-bottom: 10px;
    padding: 10px;
    border: none;
    resize: none;
    height: 36px;
    overflow: hidden; /* Prevent scrolling */

}

.textarea-container textarea:focus{
        outline: none;
        border:none;

    }


.textarea-container button {
    position: absolute;
    top: 50%;
    right: 0;
    transform: translateY(-50%);
    padding: 10px; /* Adjust padding for the icon */
    background: none; /* Remove the default button background */
    border: none; /* Remove the button border */
    cursor: pointer;
}

.textarea-container button img {
    width: 15px; /* Adjust the width of the icon */
    height: 15px; /* Adjust the height of the icon */
}

    form{
        margin:0;
        padding:0;
    }

    textarea::placeholder{
    color: #A3A3A3;
    font-family:'Roboto';
    font-size: 14px;
    font-style:normal;
    font-weight: 400;
    line-height: normal;
    }

    textarea{
        color: #000000; /* Set the desired text color */
        font-family: 'Roboto';
        font-size: 16px;
        font-style: normal;
        font-weight: 400;
        line-height: normal;
    /* Add any other styles you want to apply to the typed text */
    }

    .header_reply {
    display: flex;
    flex-direction: row;
    margin-bottom: 5px;
    align-items: center; /* Align items vertically in the center */
}

.user_name {
    color: #000000;
    font-family: 'Roboto';
    font-size: 15px;
    font-style: normal;
    font-weight: 500;
    line-height: normal;
    margin-left: 12px;
    padding-top:5px;

}

.user_name p, .reply_date p {
    margin: 0;
    padding: 0;
}

.reply_date {
    margin-left: 40px;
    color: #565656;
    font-family: 'Roboto';
    font-size: 10px;
    font-style: normal;
    font-weight: 500;
    line-height: normal;
    padding-top:5px;

}

.profile_picture {
    width: 20px;
    height: 20px;
    border-radius: 50%;
    border: 2px white solid;
}

.reply_content {
    margin-left: 35px;
    color: #232323;
    font-family: 'Roboto';
    font-size: 13px;
    font-style: normal;
    font-weight: 500;
    line-height: normal;
}
.dot_icon{
    width:8px;
    height:8px;
}


</style>
<div class="annQna">
    <div class="ann_header">
    <p class="author">{{$announcement->user->name}}<p>
        <p class="datetime">{{ \Carbon\Carbon::createFromTimestamp(strtotime($announcement->created_at))->format('d/m/Y h:i A')}}</p>
        @if($announcement->user_id == $currentUser->id)
        <div class="button-container">
            <div class="menu-icon" id="menuIcon2" onclick="toggleMenu(this, event)">
                <img src="{{ asset('img/threedot_white.png')}}" alt="three_dot">
            </div>
            <div class="action-menu" id="actionMenu2">
                <a href="#" data-toggle="modal" data-target="#updateAnnouncementModal" class="updateAnnouncementBtn" onclick="openUpdateModal({{ $announcement->id }})">Update Announcement</a>
                <a href="#" class="deleteAnnouncementBtn" onclick="deleteAnnouncement({{ $announcement->id }})">Delete Announcement</a>
            </div>
           
        </div>
        @endif
    </div>
    <div class="ann_content" style="cursor:default;">
    <p class="question">{{ $announcement->annQna->question }}</p>
    @php
    $comments = count($qna->replies);
    @endphp

    <div class="comment_class">
    <p class="comments_qty">{{ $comments }} comments</p>
    </div>
    </div>

  <!-- Display Q&A replies -->
  <div class="qna-reply">
    @foreach ($qna->replies as $reply)
        <div class="reply">
            <div class="header_reply">
                <img class="profile_picture" src="{{ $reply->user->profile_picture ? url($reply->user->profile_picture) : asset('path_to_default_image') }}" alt="Profile Picture" data-field="profile_picture">
                <div class="user_name">
                    <p>{{ $reply->user->name }}</p>
                </div>
                <div class="reply_date">
                    <p> {{ \Carbon\Carbon::createFromTimestamp(strtotime($reply->created_at))->format('d/m/Y h:i A')}}</p>
                </div>
            </div>
            <div class="reply_content">
                <p>{!! nl2br(e($reply->content)) !!}</p>
            </div>
        </div>
    @endforeach
</div>

<form action="{{ route('class_reply_qna', ['qna' => $qna->id]) }}" method="post">
    @csrf
    <div class="textarea-container">
        <textarea name="reply_content" rows="3" placeholder="Type your reply here"></textarea>
        <button type="submit">
            <img src="{{ asset('img/reply_icon.png') }}" alt="reply_icon">
        </button>
    </div>
</form>
</div>

<script>
</script>

@endsection