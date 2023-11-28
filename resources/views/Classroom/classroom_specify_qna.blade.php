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
        background: #FFFFFF;
 
    }

    .ann_header{
        display: flex;
        flex-direction: row;
        border-radius: 8px 8px 0 0;
        background: #0195FF;
        padding:5px 20px 5px 20px;
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
    }

    .ann_content{
        display:flex;
        flex-direction: column;
        border-top: 1px solid #BFBFBF;
        cursor: pointer;
        background: #FAFAFA;
        border-bottom: 1px solid #BFBFBF;
       
        padding-top:15px;
        padding-bottom: 5px;
       
    }

    .ann_content p{
        margin:0;
        padding:0;
    }

    .question{
        color: #000000;
        font-family: 'Roboto';
        font-size: 25px;
        font-style: normal;
        font-weight: 500;
        line-height: normal;
    }

    .comments_qty{
        color: #000000;
        font-family: 'Roboto';
        font-size: 15px;
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
        margin-top: 10px; /* Adjust the margin as needed */
        overflow-y: auto; /* Add scrollbars when content exceeds the container height */
        max-height: 200px; /* Set the maximum height as needed */   
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

    .qna_add_reply button img {
        width: 20px; /* Adjust the width of the icon */
        height: 20px; /* Adjust the height of the icon */
    }

.textarea-container {
    position: relative;
    border-top:1px solid #BFBFBF;
    border-radius:0 0 8px 8px;
    height:50px;
    padding-bottom:5px;
}

.textarea-container textarea {
    width: calc(100% - 35px); /* Adjust the width and subtract the button width + margin */
    box-sizing: border-box;
    margin-bottom: 10px; /* Adjust the margin as needed */
    padding: 10px; /* Adjust the padding as needed */
    border: none; /* Remove the textarea border */
    resize:none;
    height:50px;
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
    width: 20px; /* Adjust the width of the icon */
    height: 20px; /* Adjust the height of the icon */
}

    form{
        margin:0;
        padding:0;
    }

    textarea::placeholder{
    color: #A3A3A3;
    font-family:'Roboto';
    font-size: 16px;
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

</style>
<div class="annQna">
    <div class="ann_header">
    <p class="author">{{$announcement->user->name}}<p>
        <p class="datetime">{{ \Carbon\Carbon::createFromTimestamp(strtotime($announcement->created_at))->format('d/m/Y h:i A')}}</p>
    </div>
    <div class="ann_content" onclick="redirect('{{ route('class_specify_qna', ['qna' => $announcement->annQna->id]) }}')">
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
            <p>{{ $reply->user->name }} replied on {{ \Carbon\Carbon::createFromTimestamp(strtotime($reply->created_at))->format('d/m/Y h:i A')}}</p>
            <p>{!! nl2br(e($reply->content)) !!}</p>
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