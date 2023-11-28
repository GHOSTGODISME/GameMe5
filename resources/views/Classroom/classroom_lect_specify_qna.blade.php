@extends('Layout/classroom_lect_specify_master')

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
        background: #FAFAFA;
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
<div class="annQna">
    <div class="ann_header">
    <p class="author">{{$announcement->user->name}}<p>
        <p class="datetime">{{ \Carbon\Carbon::createFromTimestamp(strtotime($announcement->created_at))->format('d/m/Y h:i A')}}</p>
    </div>
    <div class="ann_content" onclick="redirect('{{ route('class_specify_qna', ['qna' => $announcement->annQna->id]) }}')">
    <p>{{ $announcement->annQna->question }}</p>
    @php
    $comments = count($qna->replies);
    @endphp
    <p>{{ $comments }} comments</p>

    </div>

  <!-- Display Q&A replies -->
  <div class="qna-reply">
    @foreach ($qna->replies as $reply)
        <div class="reply">
            <p>{{ $reply->user->name }} replied on {{ \Carbon\Carbon::createFromTimestamp(strtotime($reply->created_at))->format('d/m/Y h:i A')}}</p>
            <p>{{ $reply->content }}</p>
        </div>
    @endforeach
</div>
    
<!-- Add Reply Form -->
<div class="qna_add_reply">
    <form action="{{ route('class_reply_qna', ['qna' => $qna->id]) }}" method="post">
        @csrf
        <textarea name="reply_content" rows="3" placeholder="Add a reply..."></textarea>
        <button type="submit">Reply</button>
    </form>
</div>

</div>

<script>
</script>
@endsection