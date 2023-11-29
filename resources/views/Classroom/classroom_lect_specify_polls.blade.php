@extends('Layout/classroom_lect_specify_master')

@section('title', 'Classroom')

@section('content')
<style>

.polls-page a {
    text-decoration: underline;
    /* Add any other styles for the current page link */
    }

    
 .annPolls{
        border-radius: 8px;
        border: 1px solid #BFBFBF;
        margin-bottom:30px;
        background: #3CCBC3;
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
   

    .option_big_container {
        display: flex;
        flex-direction: row;
        justify-content: space-between;
    }

    .option_one,
    .option_two {
        border: 1px solid #ddd;
        padding: 10px;
        margin: 5px;
    }

    .polls_result {
        margin-top: 20px;
    }

</style>

<div class="annPolls">
    <div class="ann_header">
    <p class="author">{{$announcement->user->name}}<p>
        <p class="datetime">{{ \Carbon\Carbon::createFromTimestamp(strtotime($announcement->created_at))->format('d/m/Y h:i A')}}</p>
    </div>
    <div class="ann_content">
    <p>{{ $announcement->annPolls->question }}</p>
    </div>

    <div class="polls_result">
        <p>Results:</p>
        <p>{{$announcement->annPolls->option1}}: {{ $option1Count }} votes</p>
        <p> {{$announcement->annPolls->option2}}: {{ $option2Count }} votes</p>
    </div>
    @if (!$userHasVoted)
    <form action="{{ route('class_reply_polls') }}" method="post">
        @csrf
        <div class="option_big_container">
            <div class="option_one">
                <label for="option1">
                    <input type="radio" name="poll_option" id="option1" value="1">
                    {{$announcement->annPolls->option1}}:
                </label>
            </div>
            <div class="option_two">
                <label for="option2">
                    <input type="radio" name="poll_option" id="option2" value="2">
                    {{$announcement->annPolls->option2}}:
                </label>
            </div>
        </div>

        <input type="hidden" name="polls_id" value="{{ $polls->id }}">
        <input type="submit" value="Submit">
    </form>
@else
    <p>You have already voted for this poll.</p>
@endif
</div>

<script>
</script>
@endsection